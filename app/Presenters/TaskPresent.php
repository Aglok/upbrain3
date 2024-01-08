<?php

namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;
use Lavary\Menu\Collection;

class TaskPresent extends Present
{

    /**
     * Предмет
     **/
    public string $subject;
    /**
     * Имя предметов
     **/
    public string $section_name;
    /**
     * Коллекции список задач
     **/
    public Collection $tasks;

    public function __construct(Model $model, $subject)
    {
        parent::__construct($model);
        $this->subject = $subject;
        $this->model = $model;
    }

    /**
     * Получим список задач, по связной модели
     **/
    public function tasks(){
        return $this->model->tasks()->orderBy('number_task', 'asc')->get();
    }
}