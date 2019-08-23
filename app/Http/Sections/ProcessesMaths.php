<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;

/**
 * Class ProcessesMaths
 *
 * @property \App\Models\ProcessMath $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ProcessesMaths extends Section
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
            ->setColumns([
                AdminColumn::text('user.full_name', 'Имя'),
                AdminColumn::text('number_task', 'Номер задачи'),
                AdminColumn::text('stage_id', 'Stage'),
                AdminColumn::text('experience', 'Experience'),
                AdminColumn::text('gold', 'Gold'),
                AdminColumn::text('number_lesson', 'Number Lesson'),
                AdminColumn::text('rating', 'Rating'),
                AdminColumn::text('comment', 'Comment')
            ])->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('number_task', 'Номер задачи'),
            AdminFormElement::text('stage_id', 'Stage'),
            AdminFormElement::text('experience', 'Experience'),
            AdminFormElement::text('gold', 'Gold'),
            AdminFormElement::text('number_lesson', 'Number Lesson'),
            AdminFormElement::text('rating', 'Rating'),
            AdminFormElement::text('comment', 'Comment')
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
