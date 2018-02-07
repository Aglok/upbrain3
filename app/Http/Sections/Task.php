<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;

/**
 * Class Task
 *
 * @property \App\Models\Task $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Task extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay($scopes = null)
    {
        \Meta::addJs('tasks', asset('js/aglok/tasks.js'),'admin-default', true)
            ->addJs('mathjax', 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=default','admin-default');

        $display = AdminDisplay::datatables()
            ->setHtmlAttribute('class', 'table-primary')
            ->setFilters([
                AdminDisplayFilter::related('subject_id')
                    ->setModel(\App\Models\Subject::class)
                    ->setTitle(function($id){
                        return \App\Models\Subject::find($id)->name;
                }),
                AdminDisplayFilter::related('set_of_task_id')
                    ->setModel(\App\Models\Set_Of_Task::class)
                    ->setTitle(function($id){
                        return \App\Models\Set_Of_Task::find($id)->name;
                })
            ])
            ->setColumns([
                AdminColumn::link('number_task', 'Номер'),
                AdminColumn::text('task', 'Задачи'),
                AdminColumn::text('experience', 'Опыт'),
                AdminColumn::text('gold', 'Золото'),
                AdminColumn::text('grade', 'Уровень'),
                //AdminColumn::text('subject.name', 'Тема')
//                    ->append(AdminColumn::filter('subject_id'))
//                    ->setSearchCallback(function (){return false;}),
//                AdminColumn::text('answer', 'Ответ'),
//                AdminColumn::text('detail', 'Решение'),
                AdminColumn::text('setOfTask.name', 'Набор задач')
                    ->append(AdminColumn::filter('set_of_task_id'))
                    ->setSearchCallback(function (){return false;}),
//                AdminColumn::text('original_number', 'Номер из книги'),
                AdminColumn::text('rating', 'Рейтинг')->setSearchCallback(function (){return false;}),
                AdminColumn::text('comments', 'Комментарии')->setSearchCallback(function (){return false;}),
            ])->paginate(100)->setDisplaySearch(true);

        //Принимает запрос через scopes, который отфильтровывает данные
        if($scopes){
            $display->setScopes($scopes);
        }

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('number_task', 'Номер'),
            AdminFormElement::text('task', 'Задачи'),
            AdminFormElement::number('experience', 'Опыт'),
            AdminFormElement::number('gold', 'Золото'),
            AdminFormElement::text('grade', 'Уровень'),
            AdminFormElement::select('subject_id', 'Тема')
                ->setModelForOptions(\App\Models\Subject::class)
                ->setDisplay('name')->required(),
            AdminFormElement::text('answer', 'Ответ'),
            AdminFormElement::wysiwyg('detail', 'Решение', 'simplemde'),
            //AdminFormElement::string('set_of_task_id', 'Set_of_task'),
            AdminFormElement::text('original_number', 'Номер из книги')
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // todo: remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // todo: remove if unused
    }
}
