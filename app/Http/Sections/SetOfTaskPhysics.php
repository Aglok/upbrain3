<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;

/**
 * Class SetOfTaskPhysics
 *
 * @property \App\Models\SetOfTaskPhysics $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class SetOfTaskPhysics extends Section
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
                //AdminColumn::image('image', 'Изображение'),
                AdminColumn::link('name', 'Название'),
                AdminColumn::link('alias', 'Кратко'),
                AdminColumn::link('description', 'Описание'),
                AdminColumn::link('set_of_task_type.name', 'Тип')
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

            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('alias', 'Кратко'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('type', 'Тип', \App\Models\SetOfTaskType::class)->setDisplay('name')
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
