<?php

namespace App\Http\Controllers;

use App\Models\Artifact;
use App\Models\Mission;
use App\Models\Task;
use DB;
use App\Models\Set_Of_Task;
use Illuminate\Http\Request;
use AdminSection;

class UserMissionController extends Controller
{
    /**
     * Получаем список всех существующих миссий
     * @return \View $view
     */
    public function getMissions()
    {
        //Набор названия столбцов для таблицы: возможно брать список из таблицы и перевод включать в lang
        $columns = [
            'id' => '',
            'name' => 'Название',
            'description' => 'Описание',
            'list_tasks_id' => 'Задачи',
            'list_artifacts_id' => 'Артифакты',
            'condition' => 'Условия',
            'user_level' => 'Уровень',
            '' => '',
        ];

        $list_missions = $this->getListMissions();
        $missions = $list_missions[0];
        $missions_param = $list_missions[1];

        $view = view('admin.missions.list_missions', [
            'columns' => $columns,
            'missions' => $missions,
            'missions_param' => $missions_param,
        ]);

        //Добавляем по умолчанию в шаблон общие переменные menu, adminTitle, pageTitle, user
        $view = AdminSection::view($view->renderSections()["innerContent"], '');
        //dd($view);
        return $view;
    }

    /**
     * Вспомогательная функция для получения данных mission, artifacts
     * @return array
     */
    public function getListMissions()
    {
        //Массив содержит список артифактов и задач для каждого задания
        $missions_param = [];
        $missions = DB::table('missions')
            ->select('id', 'name', 'description', 'list_tasks_id', 'list_artifacts_id', 'condition', 'user_level')
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($missions as $mission):
            $artifacts = DB::table('artifacts as art')
                ->leftJoin('artifacts_type as art_t', 'art.artifact_type_id', '=', 'art_t.id')
                ->select('art.id', 'art.name', 'image', 'art.description', 'art_t.dir', 'image', 'artifact_type_id', 'attack', 'damage_min', 'damage_max', 'defense', 'magic', 'energy', 'increase_experience', 'increase_gold', 'rarity_id', 'weight', 'user_level', 'class_person_id', 'condition', 'durability', 'price')
                ->whereIn('art.id', explode(',', $mission->list_artifacts_id))
                ->orderBy('art.id', 'ASC')
                ->get();

            $tasks = DB::table('tasks')
                ->select('id', 'task', 'image', 'experience', 'gold', 'grade', 'set_of_task_id')
                ->whereIn('id', explode(',', $mission->list_tasks_id))
                ->orderBy('id', 'ASC')
                ->get();

            $missions_param[$mission->id]['artifacts'] = $artifacts;
            $missions_param[$mission->id]['tasks'] = $tasks;
        endforeach;

        return [$missions, $missions_param];
    }

    /**
     * Создаём форму для создания миссии
     * @return \View $view
     */
    public function CreateFormMission()
    {
        $set_of_tasks = Set_Of_Task::all();
        $list_artifacts = DB::table('artifacts as art')
            ->leftJoin('artifacts_type as art_type', 'art.artifact_type_id', '=', 'art_type.id')
            ->select('art.id', 'art.name', 'art.description', 'art.image', 'art.user_level', 'art_type.dir')
            ->get();

        $view = view('admin.missions.create_mission', [
            'set_of_tasks' => $set_of_tasks,
            'list_artifacts' => $list_artifacts,
        ]);

        $view = AdminSection::view($view->renderSections()["innerContent"], '');

        return $view->render();
    }

    /**
     * Создаём форму для редактирования миссии
     * @return \View $view
     */
    public function EditFormMission($mission_id)
    {

        $mission = Mission::select()->where('id', $mission_id)->first();
        $set_of_tasks = Set_Of_Task::select()->get();

        $artifacts_checked = DB::table('artifacts as art')
            ->leftJoin('artifacts_type as art_t', 'art.artifact_type_id', '=', 'art_t.id')
            ->select('art.id', 'art.name', 'image', 'art.description', 'art_t.dir', 'image', 'artifact_type_id', 'attack', 'damage_min', 'damage_max', 'defense', 'magic', 'energy', 'increase_experience', 'increase_gold', 'rarity_id', 'weight', 'user_level', 'class_person_id', 'condition', 'durability', 'price')
            ->whereIn('art.id', explode(',', $mission->list_artifacts_id))
            ->orderBy('art.id', 'ASC')
            ->get();


        $list_artifacts = DB::table('artifacts as art')
            ->leftJoin('artifacts_type as art_type', 'art.artifact_type_id', '=', 'art_type.id')
            ->select('art.id', 'art.name', 'art.description', 'art.image', 'art.user_level', 'art_type.dir')
            ->get();

        $tasks_checked = DB::table('tasks')
            ->select('id', 'task', 'image', 'experience', 'gold', 'grade', 'set_of_task_id')
            ->whereIn('id', explode(',', $mission->list_tasks_id))
            ->orderBy('id', 'ASC')
            ->get();

        $list_tasks = Task::select(['id', 'task'])->where('set_of_task_id', '=', $mission->set_of_tasks_id)->get();

        // dd($list_tasks[0]->id, $tasks_checked,$artifacts_checked);
        $view = view('admin.missions.edit_mission', [
            'mission' => $mission,
            'set_of_tasks' => $set_of_tasks,
            'artifacts_checked' => $artifacts_checked,
            'list_artifacts' => $list_artifacts,
            'tasks_checked' => $tasks_checked,
            'list_tasks' => $list_tasks,
        ]);

        $view = AdminSection::view($view->renderSections()["innerContent"], '');

        return $view;
    }

    /**
     * @param Request $request
     * @return View @view
     * Принимаем ajax запрос из списка набора задач id, отправляем список задач из этого списка
     * */
    public function getTasks(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->get('id');
                $list_tasks = Task::select(['id', 'task'])->where('set_of_task_id', '=', $id)->get();
            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }

            $view = view('admin.missions.list_tasks', [
                'list_tasks' => $list_tasks,
            ]);

            return $view->render();
        }
    }

    /**
     * @param Request $request
     * @return View @view
     * Принимаем ajax запрос из набора артов по lvl, отправляем список артифактов из этого списка
     * */
    public function getArtifacts(Request $request)
    {
        if ($request->ajax()) {
            try {
                //$id = $request->get('id');
                $list_artifacts = Artifact::select(['id', 'name', 'image', 'user_level'])->get();
            } catch (\Exception $e) {
                return view('errors.request', ['error' => $e->getMessage()]);
            }

            $view = view('admin.missions.list_artifacts', [
                'list_artifacts' => $list_artifacts,
            ]);

            return $view->render();
        }
    }

    /**
     * @param Request $request
     * @return Response
     * Принимаем ajax запрос содержащий данные о миссии, задачах и артифактах
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
