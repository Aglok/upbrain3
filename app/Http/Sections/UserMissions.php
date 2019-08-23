<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
/**
 * Class UserMissions
 *
 * @property \App\Models\UserMission $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserMissions extends Section
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
                AdminColumn::link('user.full_name', 'Ученик'),
                AdminColumn::link('mission.name', 'Задание'),
                AdminColumnEditable::checkbox('done', 'Выполнено'),
            ]);
    }

    /**
     * @param int $id
     * @return FormInterface
     */
    public function onEdit($id)
    {

        return AdminForm::panel()->addBody([
            AdminFormElement::select('user_id', 'Ученик')
                ->setModelForOptions(\App\User::class)
                ->setDisplay('full_name')->required(),
            AdminFormElement::select('mission_id', 'Задание')
                ->setModelForOptions(\App\Models\Mission::class)
                ->setDisplay('name')->required()
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
