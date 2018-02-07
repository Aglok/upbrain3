<?php namespace App\Http\Controllers;

use App\User;
use App\Models\Stage;
use DB;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use App\Helpers\UserInterface as UserI;
use App\Helpers\JoinSubjects as Subjects;
use AdminSection;

class ProcessController extends Controller
{
    /**
     * Указывает на предмет
     * @var string
     */
//    public $subject = 'math';

//    function __construct(\QueryState $queryState)
//    {
//        //Задать в роутерах переменный параметр subject
//        //Необходимо получать параметр subject по запросу чтобы генерировать динамическое изменение моделей по указанному предмету
//        // (Subject_Physics, Task_Physics....) создать переменную префикс Task.'_'.ucfirst($subject) и task.'_'.$subject
//        parent::__construct($queryState);
//    }

    /**
     * @var integer
     * @var string
     * @return View
     * */

    public function getTable($subject, $set_id)
    {

        $_subject = Subjects::_Subject($subject);

        //Набор названия столбцов для таблицы: возможно брать список из таблицы и перевод включать в lang
        $columns = [
            'id' => '' ,
            'number_task'=> '№' ,
            'task' => 'Задача' ,
            'original_number' => 'Источник' ,
            'experience' => 'Опыт' ,
            'gold' => 'Монет',
            'grade' => 'Трудность',
            'subject_name' => 'Предмет',
            'rating' => 'Рейтинг' ,
            'comment' => 'Комментарий'
        ];

        $rows = DB::table('tasks'.$_subject.' as t')
            ->leftJoin('subjects'.$_subject, 't.subject_id', '=', 'subjects'.$_subject.'.id')
            ->select(['t.id','t.number_task','t.task','t.original_number','t.experience','t.gold', 't.grade','subjects'.$_subject.'.name','t.subject_id'])
            ->where('set_of_task_id', '=', $set_id)
            ->orderBy('t.number_task', 'ASC')
            ->get();

        //$set_desc = DB::table('set_of_tasks')->select('description')->where('id', $set_id)->first();

        $count = DB::table('tasks'.$_subject.' as t')->count();
        //Выбор номера уникальной группы: возможно просто записать в html статично
        $groups = DB::table('users')->select(DB::raw('DISTINCT `group'.$_subject.'`'))->orderBy('group'.$_subject)->get();
    
        $view = view('admin.process.table', [
            'count' => $count,
            'columns' => $columns,
            'rows' => $rows,
            'groups' => $groups,
            'set_id' => $set_id,
            'subject' => $subject
            //'set_desc' => $set_desc->description
        ]);

        return AdminSection::view($view->renderSections()["innerContent"], '');

    }
    /**
     * @param Request $request
     * @param Response $response
     * @param string $subject параметр приходящий через роутер process/{phys}/save по ajax в process.js
     * @return Object
     * Принимаем ajax запрос формат json - массив объектов и отправляем текст о успешном добавлении
     * */
    public function saveProcess(Request $request, Response $response, $subject)
    {

        if($request->ajax()) {

            $_subject = Subjects::_Subject($subject);

            $result = $request->get('json');
            $result = json_decode($result);

            try {
                    //Поставить заглушку на проверку выбранной опции, как свойства объекта
                    $userObject = $result->user;
                    $user = $userObject->users;
                    $stage = $userObject->stages;
                    $number_lesson = $userObject->number_lesson;
                    //$group = $userObject->group;

            }catch (\Exception $e){
                return view('errors.request', ['error' => $e->getMessage()]);
            }

            foreach($result as $key => $value){
                try {
                    if($key == 'task') {

                        $arr = $this->validateProcessesNumberTasks($user, $value, $_subject);//массив проверки на задачи

                        for ($i = 0; $i < count($value); $i++) {

                            $number_task = $value[$i]->number_task;
                            $experience = $value[$i]->experience;
                            $gold = $value[$i]->gold;
                            $rating = $value[$i]->rating;
                            $comment = $value[$i]->comment;

                            if (!$arr[0])
                                return $response->json(['Нашлись задачи которые уже есть в БД ученика id=' . $user, $arr[1]]);

                            DB::table('processes' . $_subject)->insert([
                                'user_id' => $user,
                                'stage_id' => $stage,
                                'number_task' => $number_task,
                                'experience' => $experience,
                                'gold' => $gold,
                                'rating' => $rating,
                                'comment' => $comment,
                                'number_lesson' => $number_lesson,
                            ]);

                        }
                    }

                    if ($key == 'D' || $key == 'C' || $key == 'B' || $key == 'A') {

                        for ($i = 0; $i < count($value); $i++) {

                            $grade_char = $value[$i]->grade;
                            $sumExp = $value[$i]->sumExp;
                            $sumGold = $value[$i]->sumGold;
                            $sumTask = $value[$i]->sumTask;
                            $subject_id = $value[$i]->subject_id;


                            DB::table('grade'.$_subject)->insert([
                                'subject_id' => $subject_id,
                                'user_id' => $user,
                                'grade_char' => $grade_char,
                                'sum_tasks' => $sumTask,
                                //'full' => $full,
                                'number_lesson' => $number_lesson,
                                'sum_exp' => $sumExp,
                                //'time' => $time,
                                'sum_gold' => $sumGold,]);
                        }
                    }
                }catch (\Exception $e){
                    return view('errors.request', ['error' => $e->getMessage()]);
                }
            }

            return $response->json(['Задачи успешно добавились в БД', $result]);
        }

    }

    /**
     * @param integer $user_id
     * @param array $arr_tasks
     * @param string $_subject
     * @return array
     * Функция проверяет на наличие задачи в БД перед тем как сохранить в БД
     * Возвращает массив из true/false и массив совпавших номеров задач
     * */

    public function validateProcessesNumberTasks($user_id, $arr_tasks, $_subject){

        $arr_number_tasks = [];//массив содержит задачи которые уже есть в БД ученика
        $bool = true;//ярлык для определения дубляжа задач

        //Выберем все задачи которые были уже в базе ученика

        $number_tasks_db = DB::table('processes'.$_subject)
            ->select('number_task')
            ->where('user_id', $user_id)
            ->get();

        for ($i = 0; $i < count($arr_tasks); $i++){
            $number_task = $arr_tasks[$i]->number_task;

            foreach ($number_tasks_db as $obj):

                if($obj->number_task == $number_task){
                    array_push($arr_number_tasks, $number_task);
                    $bool = false;
                }

            endforeach;
        }

        return [$bool, $arr_number_tasks];
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $subject
     * @return object
     * Принимаем ajax запрос из списка групп id, отправляем список учеников в группе
     * */
    public function getUsers(Request $request, Response $response, $subject)
    {
        if($request->ajax()){
            try {
                $_subject = Subjects::_Subject($subject);
                $id = $request->get('id');

                $query = User::select(['id' ,'name', 'surname'])->where('group'.$_subject, '=', $id)->get();
                $param = (object)['idNameSelect' => 'users', 'url' => 'user', 'prop' => ['name', 'surname']];

            }catch (\Exception $e){
                return view('errors.request', ['error' => $e->getMessage()]);
            }
            return $response->json([$query, $param]);
        }
    }

    /**
     * @param Request $request
     * Получает id пользователя и вытаскиваем его трифеи или артефакты
     * Проверяем усиление на получение опыта или монет
     * @param Response $response
     * @return Object
     * */
    public function getStages(Request $request, Response $response)
    {
        if($request->ajax()){
            try{
                $user_id = $request->get('id');

                $artifacts = UserI::getArtifactPersonFilteredForExpGold($user_id);

                $query = Stage::select(['id' ,'name', 'alias'])->get();
                $param = (object)['idNameSelect' => 'stages', 'url' => '', 'prop' => ['name', 'alias']];
            }catch (\Exception $e){
                return view('errors.request', ['error' => $e->getMessage()]);
            }
            return $response->json([$query, $param, $artifacts]);
        }
    }

    /**
     * @return View
     * */
    public function getSetOfTasks($subject)
    {
        $_subject = Subjects::_Subject($subject);

        //Набор названия столбцов для таблицы: возможно брать список из таблицы и перевод включать в lang
        $columns = [
            '№' => '№',
            'name' => 'Набор задач',
            'tasks_count' => 'Количество задач',
            'sum_experience' => 'Суммарный опыт',
            'sum_gold' => 'Сумма монет',
            'tasks_pdf' => '',
            'list_pdf' => ''
        ];

        $count = DB::table('set_of_tasks'.$_subject)->count();

        $rows = DB::table('tasks'.$_subject.' as t')
            ->leftJoin('set_of_tasks'.$_subject, 't.set_of_task_id', '=', 'set_of_tasks'.$_subject.'.id')
            ->select(DB::raw('count(*) as tasks_count, set_of_tasks'.$_subject.'.name, t.set_of_task_id as set_id, sum(t.experience) as sum_exp, sum(t.gold) as sum_gold'))
            ->groupBy('set_of_task_id')
            ->orderBy('set_of_tasks'.$_subject.'.id', 'ASC')
            ->get();

        $view = view('admin.process.set_of_tasks', [
            'count' => $count,
            'columns' => $columns,
            'rows' => $rows,
            'subject' => $subject
        ]);

        return AdminSection::view($view->renderSections()["innerContent"], '');

    }
}