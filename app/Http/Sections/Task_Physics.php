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
 * Class Task_Physics
 *
 * @property \App\Models\Task_Physics $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Task_Physics extends Section
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
    public function onDisplay()
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setFilters([
                AdminDisplayFilter::related('subject_id')->setModel(\App\Models\Subject_Physics::class)
            ])
            ->setColumns([
                AdminColumn::link('number_task', 'Номер'),
                //AdminColumn::text('task', 'Задачи'),
                AdminColumn::link('experience', 'Опыт'),
                AdminColumn::link('gold', 'Золото'),
                AdminColumn::link('grade', 'Уровень'),
                AdminColumn::link('subject.name', 'Тема')->append(AdminColumn::filter('subject_id')),
                AdminColumn::link('answer', 'Ответ'),
                AdminColumn::text('detail', 'Решение'),
                //AdminColumn::string('set_of_task_id', 'Set_of_task'),
                AdminColumn::link('original_number', 'Номер из книги'),
            ]);
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
            //AdminFormElement::text('task', 'Задачи'),
            AdminFormElement::number('experience', 'Опыт'),
            AdminFormElement::number('gold', 'Золото'),
            AdminFormElement::text('grade', 'Уровень'),
            AdminFormElement::select('subject_id', 'Тема')
                ->setModelForOptions(\App\Models\Subject_Physics::class)
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
