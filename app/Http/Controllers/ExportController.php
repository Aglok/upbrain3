<?php namespace App\Http\Controllers;

use App\Presenters\TaskPresent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DB;
use App\Helpers\JoinSubjects as Subjects;
use Illuminate\Contracts\Routing\ResponseFactory as Response;

class ExportController extends Controller
{
    /**
     * @var object
     * Объект содержит характеристики задач
     **/
    public object $tasks;


    /**
     * @param Request $request
     * @param string $subject Строка содержит название предмет
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function pdfView(Request $request, string $subject)
    {

        $_subject = Subjects::_Subject($subject);

        $set_id = $request->get('id');
        $table_task = 'tasks'.$_subject;
        $table_subjects = 'sections'.$_subject;
        $modelSetOfTask = 'App\Models\SetOfTask'.ucfirst($subject);
        $modelSections = 'App\Models\Sections'.ucfirst($subject);

        if (!empty($set_id)) {

            $sum_exp = $request->get('sum_exp');
            $sum_gold = $request->get('sum_gold');
            $count = $request->get('count');
            $set_of_tasks = new TaskPresent($modelSetOfTask::find($set_id), $subject);//Поиск модели SetOfTask

            if ($request->has('tasks')) {

                $tasks = $set_of_tasks->tasks();

                return view('admin.export.pdfviewtasks', ['tasks' => $tasks, 'sum_exp' => $sum_exp, 'sum_gold' => $sum_gold, 'count' => $count]);
            }

            if ($request->has('list')) {

                $tasks = $set_of_tasks->tasks();
                $this->tasks = $tasks;
                $buildList = $this->buildTableList();

                //Получим список групп
                $groups = DB::table('users')->select(DB::raw('DISTINCT `group'.$_subject.'`'))->orderBy('group'.$_subject)->get();

                return view('admin.export.pdfviewlist', ['buildList' => $buildList, 'sum_exp' => $sum_exp, 'sum_gold' => $sum_gold, 'count' => $count, 'groups' => $groups]);
            }
        } else {
            return redirect()->to('admin');
        }

    }

    public function buildTableList()
    {

        $subject = '<td></td><td>Раздел</td>';
        $number_task = '<td></td><td>Номер</td>';
        $experience = '<td></td><td>Опыт</td>';
        $gold = '<td></td><td>Монет</td>';
        $grade = '<td></td><td>Трудность</td>';
        $answer = '<td></td><td>Ответы</td>';
        $i = 1;

        foreach ($this->tasks as $task):

            $subject .= '<td>' . $i++ . '</td>';
            $number_task .= '<td>' . $task->number_task . '</td>';
            $experience .= '<td>' . $task->experience . '</td>';
            $gold .= '<td>' . $task->gold . '</td>';
            $grade .= '<td>' . $task->grade . '</td>';
            $answer .= '<td>' . $task->answer . '</td>';

        endforeach;

        return (object)[
            'subject' => $subject,
            'number_task' => $number_task,
            'experience' => $experience,
            'gold' => $gold,
            'grade' => $grade,
            'answer' => $answer
        ];
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return object
     * Функция принимает ajax параметр group и возвращает объект users
     **/

    public function getGroupUsers(Request $request, Response $response)
    {
        if ($request->ajax()) {
            try {
                $users = DB::table('users')->where('group_math', $request->get('group'))->get();
            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }
            return $response->json($users);
        }
    }

    public function getJsonTasks(Request $request, Response $response){
        return $response->json(\App\Models\TaskMath::all()->where('id', '<', 20));
    }
}
