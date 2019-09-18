<?php

namespace App\Imports;

use App\Models\TaskMath;
use DB;
use function explode;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TasksImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param string
     * alias предмета math, physics
     */
    public $subject;


    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        //$_subject = Subjects::_Subject($subject);
        $modelTask = 'App\Models\Task'.ucfirst($this->subject);

        //выбираем последнюю в таблице по номеру задачу
        $last_task = $modelTask::latest('number_task')->first();

            //Проверяем если есть задачи, то выбираем последнюю в таблице по номеру задачу
            if (!empty($last_task))
                $last_number_task = $last_task->number_task;
            else
                $last_number_task = 0;

            if (!empty($row['number_task']) && $row['number_task'] > $last_number_task) {

                //TODO::создать таблицу task_image MorphToMany, чтобы для размещения изображений задач
                //TODO::использовать привязки
                if($this->subject == 'math'){
                    $insert = [
                        'number_task' => $row['number_task'],
                        'task' => $row['task'],
                        'image' => $row['image'],
                        'experience' => $row['experience'],
                        'gold' => $row['gold'],
                        'grade' => $row['grade'],
                        'section_id' => $row['section_id'],
                        'answer' => $row['answer'],
                        'detail' => $row['detail'],
                        'original_number' => $row['original_number'],
                        'book' => $row['book']
                    ];
                }else{
                    $insert = [
                        'number_task' => $row['number_task'],
                        'task' => $row['task'],
                        'image_1' => $row['image_1'],
                        'image_2' => $row['image_2'],
                        'image_1_answer' => $row['image_1_answer'],
                        'image_2_answer' => $row['image_2_answer'],
                        'experience' => $row['experience'],
                        'gold' => $row['gold'],
                        'grade' => $row['grade'],
                        'section_id' => $row['section_id'],
                        'answer' => $row['answer'],
                        'detail' => $row['detail'],
                        'original_number' => $row['original_number'],
                        'book' => $row['book'],
                    ];
                }

                if (!empty($insert)) {
                    return new $modelTask($insert);
                }
            }
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}
