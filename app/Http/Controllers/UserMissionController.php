<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Helpers\JoinSubjects as Subjects;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class UserMissionController extends Controller
{

    /**
     * @param string $subject
     * @param int $mission_id
     * @return Application|Factory|View|JsonResponse|void
     * Принимаем ajax запрос из списка набора задач id, отправляем список задач из этого списка
     */
    public function getTasks(string $subject, int $mission_id)
    {
        if (request()->ajax()) {
            try {
                $_subject = Subjects::_Subject($subject);
                $tasks_function = 'task'.$_subject;
                $mission = Mission::find($mission_id);
                $list_tasks = $mission->$tasks_function()->with(['section'])->get()
                    ->map(function ($item){
                        $section = $item->section->name;
                        $item->section = $section;
                        $item->percent = $item->pivot['percent'];
                        $item->done = $item->pivot['done'];
                        //dd(collect($item));
                        return collect($item->only(['answer', 'detail' ,'image', 'experience', 'gold', 'crystal', 'number_task', 'task', 'grade', 'section', 'percent', 'done']))->filter();
                });
                $monster = $mission->monster()->first();

            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }

//            $view = view('admin.missions.list_tasks', [
//                'list_tasks' => $list_tasks,
//            ]);
            return response()->json(['tasks' => $list_tasks, 'monster' => $monster]);
        }
    }
    /**
     * @param Request $request
     * @return Application|Factory|JsonResponse|View|void
     * Принимаем ajax запрос содержащий данные о миссии, задачах и артефактах.
     * Добавить переменную condition
     * */
    public function saveMission(Request $request)
    {
        if ($request->ajax()) {
            try {
                $result = $request->get('json');
                $isEdit = $request->get('param');
                $mission_id = $request->get('id');

                $result = json_decode($result);

                $name = '';
                $description = '';
                $list_artifacts_id = '';
                $list_tasks_id = '';
                $set_of_tasks_id = '';

                foreach ($result as $key => $input) {
                    if ($input->name == 'name') {
                        $name = $input->value;
                    } elseif ($input->name == 'description') {
                        $description = $input->value;
                    } elseif ($input->name == 'artifact_id') {
                        $list_artifacts_id .= $input->value . ',';
                    } elseif ($input->name == 'task_id') {
                        $list_tasks_id .= $input->value . ',';
                    } elseif ($input->name == 'set_of_tasks_id') {
                        $set_of_tasks_id = $input->value;
                    }
                }

                $list_artifacts_id = substr($list_artifacts_id, 0, -1);
                $list_tasks_id = substr($list_tasks_id, 0, -1);

                Mission::updateOrCreate(
                ['id' => $mission_id],
                [
                    'name' => $name,
                    'description' => $description,
                    'list_artifacts_id' => $list_artifacts_id,
                    'list_tasks_id' => $list_tasks_id,
                    'set_of_tasks_id' => $set_of_tasks_id
                ]);

            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }

            return \Response::json('Задание успешно создано.');
        }
    }

    /**
     * int $mission_id
     * Принимаем get запрос содержащий id миссии
     * Удаляет из БД миссию
     * */
    public function deleteMission($mission_id)
    {
        $mission = Mission::find($mission_id);
        $mission->delete();

        return \Response::json('Выши данные успешно удалены.');
    }

}
