<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use AdminDisplayFilter;

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
    protected $checkAccess = true;

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

        $display = AdminDisplay::table()
            ->setApply(function($query) {$query->where('active', 1);})
//            ->setFilters(AdminDisplayFilter::scope('active'))
            ->with(['roles', 'user_subjects'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                    AdminColumn::image('avatar')->setWidth('80px'),
                    AdminColumn::link('fullname', 'Имя'),
                    AdminColumn::email('email', 'Email')->setWidth('150px'),
                    AdminColumn::lists('roles.label', 'Роли')->setWidth('200px'),
                    AdminColumn::lists('user_subjects.name', 'Предметы')->setWidth('200px'),
                    AdminColumnEditable::checkbox('active', 'Активирован')
            ])->paginate(20);

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
    public function onEdit($id = null)
    {

        if(is_null($id))
            $formPassword = AdminFormElement::password('password', 'Password')->addValidationRule('min:6')->required();
        else
            $formPassword = AdminFormElement::password('password', 'Password');

        return AdminForm::panel()->addBody([
            AdminFormElement::checkbox('active', 'Активировать'),
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::text('surname', 'Фамилия')->required(),
            AdminFormElement::text('email', 'E-mail')->required()->addValidationRule('email'),
            $formPassword,
            AdminFormElement::text('description', 'О себе'),
            AdminFormElement::multiselect('roles', 'Roles', \App\Role::class)->setDisplay('name'),
            AdminFormElement::multiselect('user_subjects', 'Предметы', \App\Models\Subject::class)->setDisplay('name'),
            AdminFormElement::image('avatar', 'Avatar'),
            AdminColumn::image('avatar')->setWidth('150px'),
            AdminFormElement::select('sex', 'Пол')->setEnum(['M', 'W']),
            AdminFormElement::multiselectajax('classes_person', 'Классы героя')
                ->setModelForOptions(\App\Models\ClassPerson::class)
                ->setDataDepends(['sex'])
                ->setLoadOptionsQueryPreparer(function ($element, $query) {
                    return $query->where('sex', $element->getDependValue('sex'));
                })
                ->setDisplay('name')
                ->setHelpText('Доступные классы: маг, воин, целитель, критовик, интегратор'),
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
