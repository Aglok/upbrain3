<?php namespace App\Http\Controllers;

use App\Helpers\UserInterface as UserI;
use App\Models\Artifact;
use App\Models\GradePhysics;
use App\Models\Mission;
use App\Models\Progress;
use App\Models\UserProgress;
use App\User;
use DB;
use App\Models\GradeMath;
use Illuminate\Http\Request;
use App\Helpers\JoinSubjects as Subjects;;
use AdminSection;

class UserHomeController extends Controller
{
     /**
      * @var string
      * Имя ученика
      */
     public $name;
     /**
      * @var string
      * Фамилия ученика
      */
     public $surname;
    /**
     * @var string
     * Название предмета
     */
     //public $subject = '';
     /**
      * @var integer
      * Общее количество опыта
      */
     public $sum_exp;
     public $sum_exp_phys;
     /**
      * @var integer
      * Общее количество монет
      */
     public $sum_gold;
     public $sum_gold_phys;
     /**
      * @var integer
      * Уровень ученика
      */
     public $lvl;
     /**
      * @var string
      * Путь к view шаблон интерфейса user и таблице статистики
      */
     public $template_user_table = 'admin.user.home';
     public $template_profile = 'admin.user.profile';
     /**
      * @var boolean
      * Указываем применять шаблон к админке или к пользовательскому интерфейсу:
      *   если true  - включить в вид аттрибуты user и menu,
      *   если false - отключить аттрибуты user и menu
      */
     public $isAdmin = true;

     /**
      * @var string
      * @return \View
      * */
     public function userTable($subject)
     {
         //В зависимости от get запроса ?subject=phys создаем отдельный запрос
         //$subject = \Request::get('subject');

         $_subject = Subjects::_Subject($subject);

          $columns = [
              'id' => '№',
              'student' => 'Ученик',
              'sum_experience' => 'Суммарный опыт',
              'sum_gold' => 'Сумма монет',
          ];

         //if($subject == 'math') {

             $rows = DB::table('grade'.$_subject.' as gr')
                 ->leftJoin('users', 'gr.user_id', '=', 'users.id')
                 ->select(DB::raw('count(*) as count, gr.user_id as user_id, users.name as name, users.surname as surname, sum(gr.sum_exp) as sum_exp, sum(gr.sum_gold) as sum_gold, sex'))
                 ->groupBy('user_id')
                 ->orderBy('sum_exp', 'DESC')
                 ->get();

         //}
//         elseif($subject == 'physics'){
//
//             $rows = DB::table('grade_physics as gr')
//                 ->leftJoin('users', 'gr.user_id', '=', 'users.id')
//                 ->select(DB::raw('count(*) as count, gr.user_id as user_id, users.name as name, users.surname as surname, sum(gr.sum_exp) as sum_exp, sum(gr.sum_gold) as sum_gold, sex'))
//                 ->groupBy('user_id')
//                 ->orderBy('sum_exp', 'DESC')
//                 ->get();
//         }

//         $rows = DB::select('select users.id as user_id, users.name as name, users.surname as surname, grm.sum_exp as sum_exp, grm.sum_gold as sum_gold, grp.sum_exp_phys, grp.sum_gold_phys, sex from users
//                            left join (select gr.user_id, sum(gr.sum_exp) as sum_exp, sum(gr.sum_gold) as sum_gold from `grade` as gr group by gr.user_id) grm on grm.user_id = users.id
//                            left join (select gr_p.user_id, sum(gr_p.sum_exp) as sum_exp_phys, sum(gr_p.sum_gold) as sum_gold_phys from `grade_physics` as gr_p group by gr_p.user_id) grp on grp.user_id = users.id
//                            where sum_exp <> 0 or sum_exp_phys <> 0 and users.group <> 0 or users.group_physics <> 0
//                            order by sum_exp desc');

         $view = view($this->template_user_table, [
               'columns' => $columns,
               'rows' => $rows,
               'subject' => $subject
           ]);

           if($this->isAdmin){

               $view = AdminSection::view($view->renderSections()["innerContent"], '');
           }

         return $view;
     }

     /**
      * @var string - принимает название предмета
      * @var integer - id пользователя
      * Строим массив объектов из по параметрам предмета и id юзера
      * @return \View
      * */
      public function userProfile($subject, $user_id = null){

          $data = $this->userProfileBuild($subject, $user_id);
          $view = view($this->template_profile, $data);

          if($this->isAdmin){
              $view = AdminSection::view($view->renderSections()["innerContent"], '');
          }

          return $view;
      }

      /**
       * @var string - принимает название предмета
       * @var integer - id пользователя
       * Строим массив объектов из id юзера и по всем предметам, которые существуют.
       * @return object
       * */
      public function userProfileBuildAllSubjects($user_id=null){

          if(!$user_id) $user_id = \Auth::id();
          $user_subjects = [];//массива предметов содержащий все характеристики ученика

          foreach (Subjects::listSubject() as $s){

              $subjects = User::find($user_id)->user_subjects()->get();

              if(!$subjects->pluck('alias')->contains($s))
                  continue;

              $user_subject = $this->userProfileBuild($s);
              $user_subjects['subjects'][$s] = $user_subject;
          }

          $user_class = UserI::getUserClass($user_id);

          $user_subjects['body'] = UserI::getImageCharacter($user_id);
          $user_subjects['artifacts'] = UserI::getArtifactPerson($user_id);
          $user_subjects['slots'] = UserI::getSlotsPerson();
          $user_subjects['user_id'] = $user_id;
          $user_subjects['user_class'] = count($user_class) ? $user_class[0]: "Класс героя не выбран";

          return response()->json(collect($user_subjects));
      }
      /**
         * @var string - принимает название предмета
         * @var integer - id пользователя
         * Строим массив объектов из по параметрам предмета и id юзера
         * @return array
      **/
      //TODO:: перейти с DB::table, на ORM запросы
      //TODO:: создать динамически модель взависимости о subject и получить связи
      public function userProfileBuild($subject, $user_id = null)
      {
          //Для личного кабинета post запрос, не требует передачи параметра $user_id
          if(!$user_id) $user_id = \Auth::id();

          $_subject = Subjects::_Subject($subject);

          $skills = DB::table('grade'.$_subject.' as gr')
              ->leftJoin('users', 'gr.user_id', '=', 'users.id')
              ->select(DB::raw('sum(gr.sum_exp) as sum_exp, sum(gr.sum_gold) as sum_gold, sum(gr.sum_tasks) as sum_tasks, gr.grade_char, users.name as name, users.surname as surname, users.sex as sex'))
              ->where('user_id', '=', $user_id)
              ->groupBy('grade_char')
              ->orderBy('grade_char', 'DESC')
              ->get();

          //Расчёт общей суммы опыта и монет
          $sum_exp = 0;
          $sum_gold = 0;
          $name = '';
          $surname = '';

          if(!count($skills))
            $sex = User::find($user_id)->value('sex');

          foreach ($skills as $skill) {

               $sum_exp += $skill->sum_exp;
               $sum_gold += $skill->sum_gold;
               $name = $skill->name;
               $surname = $skill->surname;
               $sex = $skill->sex;
          }
          $sum_res = compact('sum_exp', 'sum_gold', 'name', 'surname', 'sex');

          //Записываем в доступные свойства класса
          $this->sum_exp = $sum_exp;
          $this->sum_gold = $sum_gold;

          $this->lvl = UserI::convertExpInLvl($sum_exp);//записывает свойство $lvl

          $stages = DB::table('processes'.$_subject.' as pr')
              ->leftJoin('stages', 'pr.stage_id', '=', 'stages.id')
              ->select(DB::raw('count(*) as count, sum(pr.experience) as sum_exp, sum(pr.gold) as sum_gold, stages.alias as alias, stages.description as description, stages.id as stage_id'))
              ->where('user_id', '=', $user_id)
              ->groupBy('stage_id')
              ->get();

          //Получаем необходимые данные для интерфейса
          $user_progresses = UserI::getUserProgress($user_id, $subject);

          //Получить список квестов для ученика по subject_id
          $user_missions = UserI::getUserMissions($user_id, $subject);
          $missions_artifacts = UserI::getUserMissionsHtmlArtifacts($user_missions);


          $data = [
              'skills' => $skills,
              'stages' => $stages,
              'sum_res' => $sum_res,
              'lvl' => $this->lvl,
              'missions_artifacts' => $missions_artifacts,
              'user_progresses' => $user_progresses,
              'user_missions' => $user_missions,
              'subject' => $subject,
              'progresses' => Progress::where('subject_id', Subjects::getSubjectId($subject))->get(),
              'last_tasks' => UserI::getLastTasks($subject, $user_id),
              'stats' => UserI::getUserProcesses($subject, $user_id),
          ];

          return $data;
     }

    /**
     * @var integer
     * Получение шаблона для таблицы рейтинга учеников
     * @return \View
     * */
    public function userTableRating($subject){
        $this->isAdmin = false;
        $this->template_user_table = 'users.users_rating';
        return $this->userTable($subject);
    }

    /**
     * @var string
     * @var integer
     * Получение шаблона для интерфейса учеников из рейтига
     * @return \View
     * */
     public function userProfileRating($subject, $user_id){
         $this->isAdmin = false;
         $this->template_profile = 'users.home';
         return $this->userProfile($subject ,$user_id);
     }

    /**
     * @var Request $request object
     * @return array
     * Функция собирает данные из таблицы progress и tasks
     * Выбирает по трудности задач, группирует по полям user_id, section_id, number_lesson
     * И закидывает в таблицу grade
     * */
     public function upgradeSkillsUser(Request $request, $subject){

         if($request->ajax()){
             return $this->subjectTableUpdate($subject);
         }
     }

    public function subjectTableUpdate($subject){

        $grades = ['D', 'C', 'B', 'A'];

        $_subject = Subjects::_Subject($subject);

        //Обновление данных и генерирования progress
        //$progressUpdate = $this->buildProgress($subject);

        //Возьмём последние даты из таблиц grade и processes для сравнения
        $last_record_grade = DB::table('grade'.$_subject)->latest('id')->value('created_at');
        $last_record_processes = DB::table('processes'.$_subject)->latest('id')->value('created_at');

        if($last_record_processes > $last_record_grade){

            foreach ($grades as $grade):

                //Если таблица grade пуста
                if(!$last_record_grade){
                    $grade_chars = DB::table('processes'.$_subject.' as pr')
                        ->leftJoin('tasks'.$_subject.' as t' , 'pr.number_task', '=', 't.number_task')
                        ->select(DB::raw('count(*) as count, t.section_id, pr.user_id, pr.number_lesson, sum(pr.experience) as sum_exp, sum(pr.gold) as sum_gold'))
                        ->where('t.grade', '=' , $grade)
                        ->groupBy('user_id', 't.section_id', 'pr.number_lesson')
                        ->get();
                }else{
                    $grade_chars = DB::table('processes'.$_subject.' as pr')
                        ->leftJoin('tasks'.$_subject.' as t' , 'pr.number_task', '=', 't.number_task')
                        ->select(DB::raw('count(*) as count, t.section_id, pr.user_id, pr.number_lesson, sum(pr.experience) as sum_exp, sum(pr.gold) as sum_gold'))
                        ->where('t.grade', '=' , $grade)
                        ->where('pr.created_at', '>', $last_record_grade)
                        ->groupBy('user_id', 't.section_id', 'pr.number_lesson')
                        ->get();
                }

                foreach ($grade_chars as $grade_char):

                    if($subject == 'math'){

                        GradeMath::create([
                            'section_id' => $grade_char->section_id,
                            'user_id' => $grade_char->user_id,
                            'sum_tasks' => $grade_char->count,
                            'number_lesson' => $grade_char->number_lesson,
                            'grade_char' => $grade,
                            'sum_exp' => $grade_char->sum_exp,
                            'sum_gold' => $grade_char->sum_gold
                        ]);

                    }elseif ($subject == 'physics'){

                        GradePhysics::create([
                            'section_id' => $grade_char->section_id,
                            'user_id' => $grade_char->user_id,
                            'sum_tasks' => $grade_char->count,
                            'number_lesson' => $grade_char->number_lesson,
                            'grade_char' => $grade,
                            'sum_exp' => $grade_char->sum_exp,
                            'sum_gold' => $grade_char->sum_gold
                        ]);
                    }

                endforeach;
            endforeach;

            return 'Общая статистика успешно обновилась!';
        }
        else{
            return 'У вас актуальные данные на сегодняшний день!';
        }
    }

    /**
     * @var int $subject - название предмета по которому определяется набор таблиц
     * Генерируем из данных таблицы grade статистику по grade и section_id, сверяем с таблицей categories_{subjects} и progress.
     * После записывыем в таблицу users_progress
     *
     * @return \Illuminate\Http\Response
     */
    public function buildProgress($subject)
    {

        $_subject = Subjects::_Subject($subject);

        $progresses = DB::table('progresses as pr')
            ->select('id' ,'name', 'type', 'rank', 'quality','list_grade', 'list_categories_id', 'list_count_tasks', 'description', 'image')
            ->get();

        $arrayStat = [];
        $arrayUsers = [];
        //$arr = [];

        foreach ($progresses as $progress):

            //Расщепляем строку на элементы массива
            $array_count_tasks = explode(',',$progress->list_count_tasks);
            foreach ($array_count_tasks as $list_count_task):
                //Разбиваем строку вида D:1 на массив из двух элементов
                $array_count_task = explode(':', $list_count_task);
                $grade = $array_count_task[0];
                $count_task = $array_count_task[1];

                //Создаём запрос чтобы вытащить данные из статистики таблицы grade, сгруппированные по s.category_id, gr.grade_char, user_id
                $stats = DB::select('
                            select g.sum_t, g.grade_char, g.section_id, g.user_id, g.category_id from
                            (select sum(t.sum_t) as sum_t, t.grade_char, t.section_id, t.user_id, t.category_id from
                            (select count(*) as count_tasks, sum(sum_tasks) as sum_t, gr.grade_char, gr.section_id, gr.user_id, s.category_id, gr.sum_tasks from grade'.$_subject.' as gr
                            left join users on gr.user_id = users.id 
                            left join sections'.$_subject.' as s on s.id = gr.section_id
                            where s.category_id in ('.$progress->list_categories_id.') and gr.grade_char in ("'.$grade.'")
                            group by s.category_id, gr.grade_char, user_id) as t 
                            group by user_id) as g where g.sum_t >= '.$count_task.' order by g.user_id asc');
               // var_dump([$grade, $count_task, ]);
                if(!empty($stats)){
                    foreach($stats as $stat):
                        $user_id = $stat->user_id;
                        $sum_t = $stat->sum_t;
                        $grade = $stat->grade_char;
                        //Наполняем массив users для создания фильтрации значений, которые будут в случае совпадения заменяться
                        $arrayUsers[$user_id] = $user_id;
                        //Динамически создаём вложенный массив для фильтрации о объединения данных в свои ячейки массива
                        $arrayStat[$progress->type][$progress->rank][$user_id][$grade] = $sum_t;
                    endforeach;
                }
            endforeach;
        endforeach;
       //dd($arrayStat);
        //Проводим сравнение с данными таблицей progress, на совпадение статистики
        foreach ($progresses as $progress):

            $list_grade = explode(',' ,$progress->list_grade);
            $count = count($list_grade);

            foreach ($arrayUsers as $user):

                //Если юзера нет с параметрами progress, далее не рассматриваем
                if(!empty($arrayStat[$progress->type][$progress->rank][$user])){

                    //Основная проверка на длину массива, содержащего собранные данные пользователя для определения ранга в достижениях
                    if(count($arrayStat[$progress->type][$progress->rank][$user]) == $count) {
                        //array_push($arr, (Object)['user_id' => $user, 'rank' => $progress->rank, 'quality' => $progress->quality]);

                        $user_progresses = DB::table('users_progress as u_prg')
                            ->leftJoin('progresses as prg', 'u_prg.progress_id', '=', 'prg.id' )
                            ->select('u_prg.user_id', 'u_prg.progress_quality')
                            ->where('prg.id',$progress->id)
                            ->where('u_prg.user_id', $user)
                            ->get();

                        if(!empty($user_progresses)){
                            foreach ($user_progresses as $user_progress):

                                if($user_progress->progress_quality < $progress->quality){
                                    UserProgress::where('id', $user_progress->id)
                                        ->update([
                                            'progress_id' => $progress->id,
                                            'user_id' => $user,
                                            'progress_quality' => $progress->quality,
                                        ]);
                                }else{
                                    continue;
                                }
                            endforeach;
                        }else{
                            UserProgress::create([
                                'progress_id' => $progress->id,
                                'user_id' => $user,
                                'progress_quality' => $progress->quality,
                            ]);
                        }
                    }
                }
            endforeach;
        endforeach;

        return response()->json('Достижения учеников обновлены!');
    }

    /**
     * @var Request $request object
     * @return \View
     * Функция собирает данные из таблицы progress и tasks
     * Выбирает по трудности задач grade или по этапам stage_id
     * И выводит в вид для пользователя
     * */
    public function userShowTasksSolved(Request $request){

        $columns = [
            'id' => '№',
            'number_task' => 'Номер задачи',
            'task' => 'Задача',
            'experience' => 'Опыт',
            'gold' => 'Монет',
            'grade' => 'Уровень',
            'rating' => 'Рейтинг',
            'set_name' => 'Набор задач'
        ];

        $user_id = $request->get('user_id');
        $subject = $request->get('subject');
        //Сделать ввиде функции так как встречается много раз
        $_subject = Subjects::_Subject($subject);

        if($request->has('grade')){

            $grade = $request->get('grade');

            $rows = DB::table('processes'.$_subject.' as pr')
                ->leftJoin('tasks'.$_subject.' as t', 'pr.number_task', '=', 't.number_task')
                ->leftJoin('set_of_task'.$_subject.' as stt', 't.id', '=', 'stt.task_id')
                ->leftJoin('set_of_tasks'.$_subject.' as st', 'stt.set_of_task_id', '=', 'st.id')
                ->select('pr.number_task as number_task', 't.task as task', 'pr.experience as experience', 'pr.gold as gold', 'pr.rating as rating', 't.grade','st.name')
                ->where('pr.user_id', '=' , $user_id)
                ->where('t.grade', '=' , $grade)
                ->orderBy('pr.number_task', 'DESC')
                ->get();
        }

        if($request->has('stage_id')){

            $stage_id = $request->get('stage_id');

            $rows = DB::table('processes'.$_subject.' as pr')
                ->leftJoin('tasks'.$_subject.' as t', 'pr.number_task', '=', 't.number_task')
                ->leftJoin('set_of_task'.$_subject.' as stt', 't.id', '=', 'stt.task_id')
                ->leftJoin('set_of_tasks'.$_subject.' as st', 'stt.set_of_task_id', '=', 'st.id')
                ->select('pr.number_task as number_task', 't.task as task', 'pr.experience as experience', 'pr.gold as gold', 'pr.rating as rating', 't.grade' ,'st.name')
                ->where('pr.user_id', '=' , $user_id)
                ->where('pr.stage_id', '=' , $stage_id)
                ->orderBy('pr.number_task', 'DESC')
                ->get();
        }

        //var_dump($rows);
        $view = view('users.user_tasks_solved', [
            'user_id' => $user_id,
            'columns' => $columns,
            'rows' => $rows
        ]);

        return $view;
    }

    //Тестируем функции
    public function userEquipArtifact(Request $request){
        dd($request->get('action'));
    }
}
