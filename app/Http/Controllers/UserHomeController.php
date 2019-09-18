<?php namespace App\Http\Controllers;

use App\Helpers\UserInterface as UserI;
use App\Models\Artifact;
use App\Models\Progress;
use App\Models\UserProgress;
use App\User;
use Auth;
use DB;
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
     * @var integer
     * id ученика
     */
     public $user_id;
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

         //TODO:: перейти с DB::table, на ORM запросы
         //TODO:: создать динамически модель взависимости о subject и получить связи
         $rows = DB::table('grade'.$_subject.' as gr')
                 ->leftJoin('users', 'gr.user_id', '=', 'users.id')
                 ->select(DB::raw('count(*) as count, gr.user_id as user_id, users.name as name, users.surname as surname, sum(gr.sum_exp) as sum_exp, sum(gr.sum_gold) as sum_gold, sex'))
                 ->groupBy('user_id')
                 ->orderBy('sum_exp', 'DESC')
                 ->get();

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
      * @var integer|null - id пользователя
      * Строим массив объектов из по параметрам предмета и id юзера
      * @return \View
      * */
      public function userProfile($subject, $user_id = null){

          $data = $this->userProfileBuild($subject, $user_id);

          $data['user_class'] = UserI::getUserClass($user_id);
          $data['bodies'] = UserI::getActiveImageCharacter($user_id);
          $data['user_id'] = $user_id;
          $data['artifacts'] = UserI::getArtifactsPerson($user_id);

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

          if(!$user_id) $user_id = Auth::id();
          $user_subjects = [];//массива предметов содержащий все характеристики ученика

          foreach (Subjects::listSubject() as $s){

              $subjects = User::find($user_id)->user_subjects()->get();

              if(!$subjects->pluck('alias')->contains($s))
                  continue;

              $user_subject = $this->userProfileBuild($s);
              $user_subjects['subjects'][$s] = $user_subject;
          }

          $user_subjects['user_id'] = $user_id;
          $user_subjects['bodies'] = UserI::getImageCharacter($user_id);
          $user_subjects['items'] = UserI::getItemsPerson($user_id, 0);
          $user_subjects['slots'] = UserI::getSlotsPerson($user_id);
          $user_subjects['user_class'] = UserI::getUserClass($user_id);
          $user_subjects['user_property'] = UserI::getUserProperty($user_id);

          return response()->json(collect($user_subjects));
      }
      /**
         * @var string - принимает название предмета
         * @var integer - id пользователя
         * Строим массив объектов из по параметрам предмета и id юзера
         * @return array
      **/

      public function userProfileBuild($subject, $user_id = null)
      {
          //Для личного кабинета post запрос, не требует передачи параметра $user_id
          if(!$user_id) $user_id = Auth::id();

          $user = User::find($user_id);
          $_subject = Subjects::_Subject($subject);
          $grade_func = 'grade'.$_subject;
          $stages_func = 'stages'.$_subject;

          $grades = $user->$grade_func()
              ->select(DB::raw('sum(sum_exp) as sum_exp, sum(sum_gold) as sum_gold, sum(sum_tasks) as sum_tasks, grade_char'))
              ->groupBy('grade_char')
              ->orderBy('grade_char', 'DESC')
              ->get();

          //Расчёт общей суммы опыта и монет
          $sum_exp = $grades->sum('sum_exp');
          $sum_gold = $grades->sum('sum_gold');
          $sum_tasks = $grades->sum('sum_tasks');
          $name = $user->name;
          $surname = $user->surname;
          $sex = $user->sex;

          $sum_res = compact('sum_exp', 'sum_gold', 'sum_tasks', 'name', 'surname', 'sex');


          //Отношение ко многим Stage через модель Process
          $stages = $user->$stages_func()
              ->select(DB::raw('count(*) as count, sum(experience) as sum_exp, sum(gold) as sum_gold, stage_id, alias, description'))
              ->groupBy('stage_id')
              ->get();


          //Получаем необходимые данные для интерфейса
          $user_progresses = UserI::getUserProgress($user_id, $subject);

          //Получить список квестов для ученика по subject_id
          $user_missions = UserI::getUserMissions($user_id, $subject);
          $missions_artifacts = UserI::getUserMissionsHtmlArtifacts($user_missions);


          $data = [
              'grades' => $grades,
              'stages' => $stages,
              'sum_res' => $sum_res,
              'lvl' => UserI::convertExpInLvl($sum_exp),//записывает свойство $lvl,
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
        $modelGrade = 'App\Models\Grade'.ucfirst($subject);

        //Обновление данных и генерирования progress
        $progressUpdate = $this->buildProgress($subject);

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

                        //TODO::создать динамическую генерацию модели от subject
                        $modelGrade::create([
                            'section_id' => $grade_char->section_id,
                            'user_id' => $grade_char->user_id,
                            'sum_tasks' => $grade_char->count,
                            'number_lesson' => $grade_char->number_lesson,
                            'grade_char' => $grade,
                            'sum_exp' => $grade_char->sum_exp,
                            'sum_gold' => $grade_char->sum_gold
                        ]);
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
        $arr = [];
        $_subject = Subjects::_Subject($subject);
        $progresses = Progress::all();

        $arrayStat = [];
        $arrayUsers = [];

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
                            select g.sum_t, g.grade_char, g.user_id from
                            (select sum(t.sum_t) as sum_t, t.grade_char, t.user_id from
                            (select count(*) as count_tasks, sum(sum_tasks) as sum_t, gr.grade_char, gr.user_id from grade'.$_subject.' as gr
                            left join users on gr.user_id = users.id 
                            left join sections'.$_subject.' as s on s.id = gr.section_id
                            where s.category_id in ('.$progress->list_categories_id.') and gr.grade_char in ("'.$grade.'")
                            group by s.category_id, gr.section_id, gr.grade_char, user_id) as t 
                            group by grade_char, user_id) as g where g.sum_t >= '.$count_task.' order by g.user_id asc');

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

        //Проводим сравнение с данными таблицей progress, на совпадение статистики
        foreach ($progresses as $progress):

            $list_grade = explode(',' ,$progress->list_grade);
            $count = count($list_grade);

            foreach ($arrayUsers as $user):

                //Если юзера нет с параметрами progress, далее не рассматриваем
                if(!empty($arrayStat[$progress->type][$progress->rank][$user])){
                    //array_push($arr, (Object)['user_id' => $user, 'type' => $progress->type, 'rank' => $progress->rank, 'quality' => $progress->quality, 'stats' => $arrayStat[$progress->type][$progress->rank][$user]]);
                    //Основная проверка на длину массива, содержащего собранные данные пользователя для определения ранга в достижениях
                    if(count($arrayStat[$progress->type][$progress->rank][$user]) == $count) {

                        $user_progresses = User::find($user)->progresses();
                        $user_progress = $user_progresses->get()->where('id', $progress->id)->first();

                        if(!empty($user_progress)){
                            if($user_progress->pivot->progress_quality < $progress->quality){
                                $user_progresses->updateExistingPivot($progress->id, ['progress_quality' => $progress->quality]);
                            }else{
                                continue;
                            }
                        }else{
                            $user_progresses->attach($progress->id, ['progress_quality' => $progress->quality]);
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

            //TODO::одинаковые запросы
            //TODO::перейти на ORM
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

    /**
     * @var Request $request object
     * @return string
     * Функция получает запрос от drug and drop действия action, artifact_id
     * Обновляет Pivot таблицу
     * И отправляет обновлённые данные слотов, предметов и образов ученика
     * */
    public function userEquipArtifact(Request $request){


        $user_subjects = [];
        $user_id = Auth::id();

        $action = $request->get('action');
        $artifact_id = $request->get('artifact_id');

        if($action == 'item_off'){
            $this->updatePivotArtifact($user_id, $artifact_id, 0);
        }

        if($action == 'item_on'){
            $this->updatePivotArtifact($user_id, $artifact_id, 1);
        }


        $user_subjects['bodies'] = UserI::getImageCharacter($user_id);
        $user_subjects['items'] = UserI::getItemsPerson($user_id, 0);
        $user_subjects['slots'] = UserI::getSlotsPerson($user_id);
        $user_subjects['user_property'] = UserI::getUserProperty($user_id);

        return response()->json(collect($user_subjects));

    }


    public function updatePivotArtifact($user_id, $artifact_id, $equip = 0){
        User::find($user_id)->artifacts()->updateExistingPivot($artifact_id, ['equip' => $equip]);
    }
}
