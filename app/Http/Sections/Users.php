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
 * Class Users
 *
 * @property \App\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Users extends Section
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
            ->with('roles')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                    AdminColumn::image('avatar')->setWidth('80px'),
                    AdminColumn::link('fullname', 'Username'),
                    AdminColumn::email('email', 'Email')->setWidth('150px'),
                    AdminColumn::lists('roles.label', 'Roles')->setWidth('200px'),
            ])->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id = null)
    {
        if(is_null($id))
            $passwordElem = AdminFormElement::password('password', 'Password')->required();
        else
            $passwordElem = AdminFormElement::password('password', 'Password')->allowEmptyValue();

        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Username')->required(),
            $passwordElem,
            //AdminFormElement::password('password', 'Password')->allowEmptyValue()->required()->addValidationRule('min:6'),
            AdminFormElement::text('email', 'E-mail')->required()->addValidationRule('email'),
            AdminFormElement::text('description', 'О себе'),
            AdminFormElement::multiselect('roles', 'Roles', \App\Role::class)->setDisplay('name'),
            AdminFormElement::image('avatar', 'Avatar'),
            AdminColumn::image('avatar')->setWidth('150px')
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
