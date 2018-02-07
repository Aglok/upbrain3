<?php

namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;
use App\User;

class BlogPresent extends Present
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $model->orderBy('created_at', 'DESC')->paginate(5);
    }

    public function createdAt()
    {
        return $this->model->created_at->format('d.m.Y h:m');
    }

    /**
    *  Вывод коллекции тегов через связь belongToMany
     **/
    public function arrayTags(){
        return $this->model->tags()->get();
    }

    /**
    *  Вывод имень автора статьи
     **/
    public function author(){
        return User::find($this->model->user_id);
    }
}