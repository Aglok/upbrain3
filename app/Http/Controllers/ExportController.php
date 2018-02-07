<?php namespace App\Http\Controllers;

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
    public $tasks;


    /**
     * @param Request $request
     * @param integer $set_id
     * @param string $subject строка содержит название предмет
     * @return \View
     * */
    public function pdfView(Request $request, $subject, $set_id)
    {

        $_subject = Subjects::_Subject($subject);

        $table_task = 'tasks'.$_subject;
        $table_subjects = 'subjects'.$_subject;

        
        if (!empty($set_id)) {

            $sum_exp = $request->get('sum_exp');
            $sum_gold = $request->get('sum_gold');
            $count = $request->get('count');

            if ($request->has('tasks')) {

                $tasks = DB::table($table_task)->where('set_of_task_id', $set_id)->get();
                return view('admin.export.pdfviewtasks', ['tasks' => $tasks, 'sum_exp' => $sum_exp, 'sum_gold' => $sum_gold, 'count' => $count]);
            }

            if ($request->has('list')) {
                $tasks = DB::table($table_task)
                    ->join($table_subjects, $table_task.'.subject_id', '=', $table_subjects.'.id')
                    ->where('set_of_task_id', $set_id)->get();

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
                $users = DB::table('users')->where('group', $request->get('group'))->get();
            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }
            return $response->json($users);
        }
    }
}