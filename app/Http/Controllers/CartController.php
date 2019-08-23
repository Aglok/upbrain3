<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Progress;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Принимаем параметр $subject предмет и определяем модель
     * @param $subject
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSetOfTasks($subject, Request $request){

        if($request->ajax()) {

            $modelSetOfTask = 'App\Models\SetOfTask'.ucfirst($subject);
            $modelTask = 'App\Models\Task'.ucfirst($subject);
            $modelSections = 'App\Models\Sections'.ucfirst($subject);

            $tasks_cart = json_decode($request->get('tasks'));

            $tasks = [];//Массив объектов задач, отправляемый на front
            $setOfTask = $modelSetOfTask::all()->transform(function ($item){
                return $item->only(['id', 'name', 'alias', 'image', 'type', 'description']);
            });

            $progresses = Progress::whereSubjectId(Subject::whereAlias($subject)->value('id'))->get();

            foreach($tasks_cart as $task){

                $set_of_tasks = [];

                //Динамически создаём свойства id и name объекта $set_of_tasks
                $modelTask::find($task->id)->setOfTask()->get()->each(function ($item) use (&$set_of_tasks){

                        $set_of_task = new \stdClass;//Массив объектов наборов задач относящиеся к данной задаче
                        $set_of_task->id = $item->id;
                        $set_of_task->name = $item->name;

                        array_push($set_of_tasks, $set_of_task);
                });

                $task->set_of_tasks = $set_of_tasks;
                $task->section = $modelTask::find($task->id)->section()->first();
                $task->mission = $modelTask::find($task->id)->mission()->first();
                $task->pick = false;
                $tasks[] = $task;
            }

            return response()->json([$setOfTask, $tasks, $modelSections::all(), Mission::all(), Subject::all(), $progresses]);
        }
    }

    /**
     * Принимаем параметр $subject предмет и определяем модель
     * @param $subject
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSetOfTasks($subject, Request $request){
        if($request->ajax()) {

            //Динамически определяем модели и функции отношений для разных моделей - предметов (math, physics)
            $modelSetOfTask = 'App\Models\SetOfTask'.ucfirst($subject);
            $modelTaskMath = 'App\Models\Task'.ucfirst($subject);
            $functionMorphToMany = 'task_'.$subject; //Функция отношения (пример: task_math, task_physics)

            $array_no_use_tasks = [];

            $tasks_cart = json_decode($request->get('tasks'));
            $set_of_tasks = json_decode($request->get('set_of_tasks'));
            $mission = json_decode($request->get('mission'));
            $progress = json_decode($request->get('progress'));

            foreach ($set_of_tasks as $set_of_task){

                //Проверяем, создана ли модель set_of_tasks. Если нет, то создаём в БД
                if(!$modelSetOfTask::find($set_of_task->id)){
                    $modelSetOfTask::create([
                        'name' => $set_of_task->name,
                        'alias' => $set_of_task->alias,
                        'image' => $set_of_task->image,
                        'type' => $set_of_task->type,
                        'description' => $set_of_task->description
                    ]);
                }

                //Можно было не проверять через массив, а сразу использовать методы sync(), pluck()
                $array_tasks_id = [];

                foreach ($tasks_cart as $task){
                    $no_use_set  = new \stdClass;

                    //Проверка задач на совпадения к принадлежности к списку задач
                    $array_set_of_tasks = $modelTaskMath::find($task->id)->setOfTask()->pluck('set_of_task_id', 'name');
                    if(!$set = $array_set_of_tasks->search($set_of_task->id))
                        $array_tasks_id[] = $task->id;
                    else{
                        $no_use_set->set = $set;
                        $no_use_set->task_id = $task->id;
                        $array_no_use_tasks[] = $no_use_set;
                    }
                }
                //Подключение к массиву из task_id через отношение к модели SetOfTask
                if($model = $modelSetOfTask::find($set_of_task->id)) {
                    $model->tasks()->attach($array_tasks_id);

                    //Перед сохраненим в БД сверяем обновлённые данные и удаляем файл с диска
                    if($model->image && !$set_of_task->image){
                        //Небходимо было использовать в config/filesystems.php disk с использованием root относительно public
                        Storage::disk('public')->delete($model->image);
                    }
                    //Обновление данных модели, если были изменения
                    $model->name = $set_of_task->name;
                    $model->alias = $set_of_task->alias;
                    $model->image = $set_of_task->image;
                    $model->type = $set_of_task->type;
                    $model->description = $set_of_task->description;
                    $model->save();
                }
            }

            //Если квест выбран для задач
            if(!empty((array)$mission)){

                Mission::updateOrCreate(['id' => $mission->id],
                    [
                        'name' => $mission->name,
                        'description' => $mission->description,
                        'progress_id' => $progress->id,//Создали свойстов объекта динамически через v-model
                        'subject_id' => $mission->subject_id,
                        'level' => $mission->level,
                    ]
                );

                //Проверяем задачи должны быть уникальны и не повторяться у других миссий
                foreach ($tasks_cart as $task){
                    $missions = $modelTaskMath::find($task->id)->mission();
                    $ids = $missions->allRelatedIds();//Берём все связанные миссии и получаем массив из id

                    //Если миссия уже есть, то обновляем связи. Иначе пропускаем и создаём новые связи
                    if(count($ids) > 0){
                        foreach ($ids as $id){
                            $missions->updateExistingPivot($id, ['mission_id' => $mission->id]);
                        }
                    }else{
                        //Сохранение моделей задач
                        Mission::find($mission->id)->$functionMorphToMany()->attach($task->id);
                    }
                }
            }

            return response()->json($array_no_use_tasks);
        }
    }
    public function detachSetOfTask($subject, Request $request){

        if($request->ajax()) {

            $modelTaskMath = 'App\Models\Task'.ucfirst($subject);
            $set_of_task_id = $request->get('set_of_task_id');
            $task_id = $request->get('task_id');

            $modelTaskMath::find($task_id)->setOfTask()->detach($set_of_task_id);

            return response()->json('Отвязали список задач №: '.$set_of_task_id);
        }
    }

}