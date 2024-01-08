<?php namespace App\Http\Controllers;

use App\Helpers\Items\ItemsForProfile;
use App\Helpers\Items\ItemsForShop;
use App\Helpers\UserInterface as UserI;
use App\Models\Artifact;
use App\Models\Battle;
use App\Models\Progress;
use App\Models\UserTransaction;
use App\Presenters\UserPresent;
use App\User;
use Auth;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\JoinSubjects as Subjects;
use AdminSection;
use SleepingOwl\Admin\Section;
use Throwable;

class UserHomeController extends Controller
{
     /**
      * @var string
      * Путь к view шаблон интерфейса user и таблице статистики
      */
     public string $template_user_table = 'admin.user.home';
     public string $template_profile = 'admin.user.profile';
     /**
      * @var boolean
      * Указываем применять шаблон к админке или к пользовательскому интерфейсу:
      *   если true - включить в вид аттрибуты user и menu,
      *   если false - отключить аттрибуты user и menu
      */
     public bool $isAdmin = true;

    /**
     * @param string $subject
     * @return Application|Factory|View|Section
     *
     * @throws Throwable
     */
     public function userTable(string $subject): Application|Factory|View|Section
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
                 ->selectRaw('count(*) as count, gr.user_id as user_id, users.name as name, users.surname as surname, sum(gr.sum_exp) as sum_exp, sum(gr.sum_gold) as sum_gold, sex')
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
     * @param string $subject - принимает название предмета
     * @param int|null $user_id - id пользователя
     * Строим массив объектов из по параметрам предмета и id юзера
     * @return Application|Factory|View|Section
     * @throws Throwable
     */
      public function userProfileView(string $subject, int $user_id = null): Application|Factory|View|Section
      {

          $data = $this->userProfileBuildSubject($subject, $user_id);

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
     * @param int $user_id
     * @param bool $onlySum - указывает, что возвращает только массив содержащий суммы опыта, монет
     * @param bool $onlyEquip - указывает, что возвращает только массив содержащий суммы опыта, монет, stages, user_level для свойства возможность надеть/купить
     * @return array
     */
      public function userProfileBuildAllSubjects(int $user_id, $onlySum = false, $onlyEquip = false): array {

          $subjects = User::find($user_id)->user_subjects()->get();

          $user_subjects = [];//массива предметов содержащий все характеристики ученика

          foreach (Subjects::listSubject() as $s){

              if(!$subjects->pluck('alias')->contains($s))
                  continue;

              $user_subject = $this->userProfileBuildSubject($s, $user_id, $onlySum, $onlyEquip);
              $user_subjects['subjects'][$s] = $user_subject;
          }
          
          return $user_subjects;
      }

    /**
     * @param null $user_id
     * @return JsonResponse
     */
      public function userProfile($user_id=null): JsonResponse {

          //Для личного кабинета post запрос, не требует передачи параметра $user_id
          if(!$user_id) $user_id = Auth::id();

          $user_subjects = $this->userProfileBuildAllSubjects($user_id, false, false);

          //Получаем сумму по всем предметам за решённые задачи
          $gold = collect($user_subjects['subjects'])->sum(function ($subject) {
              return $subject['sum_res']['sum_gold'];
          });

          //Золото с учётом купли/продажи
          $total_gold = UserI::updateGoldsUser($user_id, $gold);

          $user_present = new UserPresent($user_subjects['subjects'], $total_gold);
          $items = new ItemsForProfile($user_id, 0, $user_present, 'canEquip');
          $shop = new ItemsForShop($user_id,  $user_present, 'canBuy');

          $user_subjects['user_id'] = $user_id;
          $user_subjects['gold'] = $total_gold;
          $user_subjects['bodies'] = UserI::getImageCharacter($user_id);
          $user_subjects['items_bag'] = collect($items->getArtifacts())->map(function($item){
                return collect($item)->except(['rarity_id', 'artifact_type_id', 'artifact_trade_id', 'pivot', 'slot_id', 'subjects', 'price', 'image', 'user_level', 'class_type_id']);
          });
          $user_subjects['shop'] = $shop->getItemsForShop();
          $user_subjects['slots'] = UserI::getSlotsPerson($user_id, $user_present);
          $user_subjects['user_class'] = UserI::getUserClass($user_id)
              ->map(function ($item){
                return collect($item)->only(['name', 'description', 'image']);
          })->first();
          $user_subjects['user_property'] = UserI::getUserProperty($user_id);
          $user_subjects['item_types'] = UserI::getArtifactTypes();
          $user_subjects['progresses'] = Progress::get()->map(function ($value, $key) {
              return collect($value)->only(['id', 'type', 'rank', 'name' ,'description', 'image']);
          });
          $user_subjects['battles'] = Battle::where('user_id', $user_id)->get();

          return response()->json(collect($user_subjects));
      }
      /**
         * @param string $subject - принимает название предмета
         * @param integer $user_id - id пользователя
         * @param bool $onlySum - указывает, что возвращает только массив содержащий суммы опыта, монет
         * @param bool $onlyEquip - указывает, что возвращает только массив содержащий суммы опыта, монет, stages, user_level для свойства возможность надеть/купить
         * Строим массив объектов из по параметрам предмета и id юзера
         * @return array
      **/

      public function userProfileBuildSubject($subject, $user_id, $onlySum = false, $onlyEquip = false): array
      {
          $user = User::find($user_id);
          $_subject = Subjects::_Subject($subject);
          $grade_func = 'grade'.$_subject;
          $stages_func = 'stages'.$_subject;

          $grades = $user->$grade_func()
              ->selectRaw('round(sum(sum_exp),2) as sum_exp, sum(sum_gold) as sum_gold, sum(sum_tasks) as sum_tasks, sum(sum_crystal) as sum_crystal, grade_char')
              ->groupBy('grade_char')
              ->orderBy('grade_char', 'DESC')
              ->get();

          //Расчёт общей суммы опыта и монет

          $sum_exp = $grades->sum('sum_exp');
          $sum_gold = $grades->sum('sum_gold');
          $sum_tasks = $grades->sum('sum_tasks');

          //Динамически создаём переменную
          $color_crystal = Subjects::getSubjectColor($subject).'_crystal';
          $$color_crystal = $grades->sum('sum_crystal');

          $name = $user->name;
          $surname = $user->surname;
          $sex = $user->sex;

          $sum_res = compact('sum_exp', 'sum_gold', 'sum_tasks', "$color_crystal" ,'name', 'surname', 'sex');

          //Возвращает только массив содержащий суммы опыта, монет и кристаллов
          if($onlySum){
              return $sum_res;
          }

          //Отношение ко многим Stage через модель Process
          $stages = $user->$stages_func()
              ->selectRaw('count(*) as count, round(sum(experience),2) as sum_exp, sum(gold) as sum_gold, stage_id, alias, description')
              ->groupBy('stage_id')
              ->get()
              ->map(function($item){
                  return collect($item)->except(['laravel_through_key']);
              });

          //Получить список квестов для ученика по subject_id
          $user_missions = UserI::getUserMissions($user_id, $subject);
          $missions_artifacts = UserI::getUserMissionsHtmlArtifacts($user_missions);


          $dataForEquip = [
              'stages' => $stages,
              'sum_res' => $sum_res,
              'user_level' => UserI::convertExpInLvl($sum_exp),//записывает свойство $lvl,
          ];

          //Возвращает только массив содержащий суммы опыта, монет и кристаллов, stages, user_level для свойства возможность надеть/купить
          if($onlyEquip){
              return $dataForEquip;
          }

          //Получаем необходимые данные для интерфейса
          $data = [
              'grades' => $grades,
              'missions_artifacts' => $missions_artifacts,
              'user_progresses' => UserI::getUserProgress($user_id, $subject),
              'user_missions' => $user_missions,
              'subject' => $subject,
              //'subject_id' => Subjects::getSubjectId($subject),
              'last_tasks' => UserI::getLastTasks($user_id, $subject),
              'stats' => UserI::getUserProcesses($user_id, $subject),
              //'shop' => UserI::getItemsForShop($user_id, $subject)
          ];

          return $data+$dataForEquip;
     }

    /**
     * @param string $subject
     * @return Application|Factory|View|Section
     * @throws Throwable
     */
    public function userTableRating(string $subject){
        $this->isAdmin = false;
        $this->template_user_table = 'users.users_rating';
        return $this->userTable($subject);
    }

    /**
     * @param string $subject
     * @param integer $user_id
     * Получение шаблона для интерфейса учеников из рейтига
     * @return Application|Factory|View|Section
     *
     * @throws Throwable
     */
     public function userProfileRating(string $subject, int $user_id){
         $this->isAdmin = false;
         $this->template_profile = 'users.home';
         return $this->userProfileView($subject ,$user_id);
     }

    /**
     * @param Request $request object
     * @return Application|Factory|View Функция собирает данные из таблицы progress и tasks
     * Функция собирает данные из таблицы progress и tasks
     * Выбирает по трудности задач grade или по этапам stage_id
     * И выводит в вид для пользователя
     */
    public function userShowTasksSolved(Request $request): Application|Factory|View
    {

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

        //Общий запрос
        $query = DB::table('processes'.$_subject.' as pr')
            ->leftJoin('tasks'.$_subject.' as t', 'pr.number_task', '=', 't.number_task')
            ->leftJoin('set_of_task'.$_subject.' as stt', 't.id', '=', 'stt.task_id')
            ->leftJoin('set_of_tasks'.$_subject.' as st', 'stt.set_of_task_id', '=', 'st.id')
            ->select('pr.number_task as number_task', 't.task as task', 'pr.experience as experience', 'pr.gold as gold', 'pr.rating as rating', 't.grade','st.name')
            ->where('pr.user_id', '=' , $user_id);

        if($request->has('grade')){

            $grade = $request->get('grade');
            $query = $query->where('t.grade', '=' , $grade);
        }

        if($request->has('stage_id')){

            $stage_id = $request->get('stage_id');
            $query = $query->where('pr.stage_id', '=' , $stage_id);

        }

        $rows = $query->orderBy('pr.number_task', 'DESC')->get();

        //var_dump($rows);
        return view('users.user_tasks_solved', [
            'user_id' => $user_id,
            'columns' => $columns,
            'rows' => $rows
        ]);
    }

    /**
     * @param Request $request object
     * @return JsonResponse
     * Функция получает запрос от drug and drop действия action, artifact_id
     * Обновляет Pivot таблицу
     * И отправляет обновлённые данные слотов, предметов и образов ученика
     * */
    public function userEquipArtifact(Request $request) : JsonResponse {

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

        if($action == 'sale'){

            //Сохраняет лог с транзакциями цены в два раза ниже, с округлением в большую сторону
            UserTransaction::create([
                'user_id' => $user_id,
                'artifact_id' => $artifact_id,
                'action' => $action,
                'gold' =>  ceil(Artifact::find($artifact_id)->artifact_trade()->value('gold')/2),
                'red_crystal' => ceil(Artifact::find($artifact_id)->artifact_trade()->value('red_crystal')/2),
                'blue_crystal' => ceil(Artifact::find($artifact_id)->artifact_trade()->value('blue_crystal')/2),
                'green_crystal' => ceil(Artifact::find($artifact_id)->artifact_trade()->value('green_crystal')/2),
                'yellow_crystal' => ceil(Artifact::find($artifact_id)->artifact_trade()->value('yellow_crystal')/2),
            ]);

            $this->detachArtifact($user_id, $artifact_id);

        }

        //Получаем все монеты пользователя полученные со всех предметов
        $gold = $this->getGoldsUser($user_id);

        $user_subjects = $this->userProfileBuildAllSubjects($user_id, false, true);
        $user_present = new UserPresent($user_subjects['subjects']);
        $items = new ItemsForProfile($user_id, 0, $user_present, 'canEquip');

        $user_subjects['gold'] = UserI::updateGoldsUser($user_id, $gold);
        $user_subjects['bodies'] = UserI::getImageCharacter($user_id);
        $user_subjects['items_bag'] = $items->getArtifacts();
        $user_subjects['slots'] = UserI::getSlotsPerson($user_id, $user_present);
        $user_subjects['user_property'] = UserI::getUserProperty($user_id);

        $crystals = $this->getArrayCrystalsUser($user_id);
        $user_subjects_with_crystal = $user_subjects + UserI::updateArrayCrystalsUser($user_id, $crystals);

        return response()->json(collect($user_subjects_with_crystal));

    }

    /**
     * @param Request $request object
     * @return JsonResponse
     * Функция получает запрос от drug and drop действия action, artifact_id
     * Обновляет Pivot таблицу
     * И отправляет обновлённые данные слотов, предметов и образов ученика
     * */
    public function userBuyArtifact(Request $request) : JsonResponse {
        $user_subjects = [];
        $user_id = Auth::id();

        $action = $request->get('action');
        $artifact_id = $request->get('artifact_id');
        $quantity = $request->get('quantity');

        if($action == 'buy'){

            dd(Artifact::find($artifact_id)->artifact_trade()->value('gold'));
            //Сохраняет лог с транзакциями, добавить поле quantity
//            UserTransaction::create([
//                'user_id' => $user_id,
//                'artifact_id' => $artifact_id,
//                'action' => $action,
//                'gold' => Artifact::find($artifact_id)->artifact_trade()->value('gold'),
//                'quantity' => $quantity,
//            ]);

            //Написать функцию которая вытаскивает Artifact::find($artifact_id)->artifact_trade(), все поля у которых значение не равно 0
            //Привязать артефакт к user, user_artifact
            //$this->attachArtifact($user_id, $artifact_id);

        }
    }

    public function updatePivotArtifact(int $user_id, int $artifact_id, int $equip = 0) :void {
        User::find($user_id)->artifacts()->updateExistingPivot($artifact_id, ['equip' => $equip]);
    }

    public function detachArtifact(int $user_id, int $artifact_id) :void {
        User::find($user_id)->artifacts()->detach($artifact_id);
    }

    /**
     * @param int $user_id
     * @return int
     * Получает все монеты пользователя наполенные со всех предметов
     * */
    public function getGoldsUser(int $user_id): int{
        return collect($this->userProfileBuildAllSubjects($user_id, true)['subjects'])->sum('sum_gold');
    }

    /**
     * @param int $user_id
     * @return array
     * Получает все доступные кристаллы пользователя наполенные со всех предметов ['red_crystal' => 2, 'blue_crystal' => 0]
     * */
    public function getArrayCrystalsUser(int $user_id): array {
        $crystals = [];
        collect($this->userProfileBuildAllSubjects($user_id, true)['subjects'])->each(function ($item, $key) use (&$crystals) {
            $color_crystal = Subjects::getSubjectColor($key).'_crystal';
            $crystals[$color_crystal] = $item[$color_crystal];
        });

        return $crystals;
    }
}
