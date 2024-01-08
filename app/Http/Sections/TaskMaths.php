<?php

namespace App\Http\Sections;

use App\Models\SetOfTaskMath;
use App\Models\TaskMath;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\FilterOperatorException;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use AdminColumnFilter;
/**
 * Class TaskMaths
 *
 * @property TaskMath $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class TaskMaths extends Section
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
     * @throws FilterOperatorException
     */
    public function onDisplay(): DisplayInterface
    {
        \Meta::addJs('tasks', asset('js/aglok/tasks.js'),'admin-default', true)
            ->addJs('mathjax', 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=default','admin-default');

        $display = AdminDisplay::datatables()
            ->setHtmlAttributes(['class'=> 'table-primary', 'id' =>'table-tasks', 'data-subject' => 'math'])
            ->setFilters([
                AdminDisplayFilter::related('section_id')
                    ->setModel(\App\Models\SectionsMath::class)
                    ->setTitle(function($id){
                        return \App\Models\SectionsMath::find($id)->name;
                }),
                AdminDisplayFilter::related('set_of_task_id')
                    ->setModel(SetOfTaskMath::class)
                    ->setTitle(function($id){
                        return SetOfTaskMath::find($id)->name;
                })
            ])
            ->setColumns([
                AdminColumn::custom('', function ($model){
                    return '<div id="tasks_button_'.$model->id.'"><div>';
                }),
                AdminColumn::link('number_task', 'Номер'),
                //AdminColumn::text('task', 'Задачи')->setWidth('400px'),
                AdminColumn::custom('Задачи', function ($model){
                    if($model->image){
                        return $model->task.'<br> <img width="180px" src="/images/tasks/'.$model->image.'">';
                    }else
                        return $model->task;
                }),
                AdminColumn::text('experience', 'Опыт'),
                AdminColumn::text('gold', 'Золото'),
                AdminColumn::text('grade', 'Уровень'),
                AdminColumn::text('section.name', 'Тема')
                    ->append(AdminColumn::filter('section_id'))
                    ->setSearchCallback(function (){return false;}),
//                AdminColumn::text('answer', 'Ответ'),
//                AdminColumn::text('detail', 'Решение'),
//                AdminColumn::text('setOfTask.name', 'Набор задач')
//                    ->append(AdminColumn::filter('set_of_task_id'))
//                    ->setSearchCallback(function (){return false;}),
//                AdminColumn::text('original_number', 'Номер из книги'),
//                AdminColumn::text('rating', 'Рейтинг')->setSearchCallback(function (){return false;}),
//                AdminColumn::text('comments', 'Комментарии')->setSearchCallback(function (){return false;}),
            ])->paginate(20);
//            ->setDisplaySearch(true);
        //$display->extend('tasks_cart', new \App\Display\Extension\DisplayFilter());
        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()
                ->setPlaceholder('№')
                ->setOperator('greater_or_equal')
                ->setHtmlAttribute('class', 'width-40'),
            null,
            //null,
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('От')->setHtmlAttribute('class', 'width-50')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('До')->setHtmlAttribute('class', 'width-50')
            ),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('От')->setHtmlAttribute('class', 'width-50')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('До')->setHtmlAttribute('class', 'width-50')
            ),
            AdminColumnFilter::select(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'])
                ->setPlaceholder('Сложность')
                ->setColumnName('grade')
                ->setHtmlAttribute('class', 'width-100'),
            AdminColumnFilter::select(new \App\Models\SectionsMath(), 'Тема')
                ->setDisplay('name')
                ->setPlaceholder('Тема')
                ->setColumnName('section_id')
                ->setHtmlAttribute('class', 'width-150'),
        ])->setPlacement('table.header');

        //Принимает запрос через scopes, который отфильтровывает данные, scopes задаётся в модели Tasks
        $payload = $this->getPayload();
        if(count($payload) > 0)
            $display->setScopes($payload['scopes']);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     * @throws SelectException
     */
    public function onEdit(int $id): FormInterface
    {
        return AdminForm::card()->addBody([
            AdminFormElement::text('number_task', 'Номер'),
            AdminFormElement::text('task', 'Задачи'),
            AdminFormElement::number('experience', 'Опыт'),
            AdminFormElement::number('gold', 'Золото'),
            AdminFormElement::text('grade', 'Уровень'),
            AdminFormElement::select('section_id', 'Тема')
                ->setModelForOptions(\App\Models\SectionsMath::class)
                ->setDisplay('name')->required(),
            AdminFormElement::multiselect('setOfTask', 'Набор задач', SetOfTaskMath::class)->setDisplay('name'),
            AdminFormElement::text('answer', 'Ответ'),
            AdminFormElement::wysiwyg('detail', 'Решение', 'simplemde'),
            //AdminFormElement::string('set_of_task_id', 'Set_of_task'),
            AdminFormElement::text('original_number', 'Номер из книги')
        ]);
    }

    /**
     * @return FormInterface
     * @throws SelectException
     */
    public function onCreate(): FormInterface
    {
        return $this->onEdit((int)null);
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
