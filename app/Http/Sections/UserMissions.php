<?php

namespace App\Http\Sections;

use App\Models\Mission;
use App\Models\UserMission;
use App\User;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
/**
 * Class UserMissions
 *
 * @property UserMission $model
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
    public function onDisplay(): DisplayInterface
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
     * @throws SelectException
     */
    public function onEdit(int $id): FormInterface
    {

        return AdminForm::card()->addBody([
            AdminFormElement::select('user_id', 'Ученик')
                ->setModelForOptions(User::class)
                ->setDisplay('full_name')->required(),
            AdminFormElement::select('mission_id', 'Задание')
                ->setModelForOptions(Mission::class)
                ->setDisplay('name')->required()
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
