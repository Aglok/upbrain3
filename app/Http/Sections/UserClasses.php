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
 * Class UserClasses
 *
 * @property \App\Models\UserClass $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserClasses extends Section
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
                AdminColumn::custom('', function(\App\Models\UserClass $user_class) {

                    $image = $user_class->class_person->image;

                    return '<a href="/'.$image.'" data-toggle="lightbox">
                    <img src="/'.$image.'" width="" class="thumbnail">
                    </a>';
                }),
                AdminColumn::link('user.full_name', 'Ученик'),
                AdminColumn::link('class_person.name', 'Класс героя'),
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
            AdminFormElement::dependentselect('class_person_id', 'Класс героя')
                ->setModelForOptions(\App\Models\ClassPerson::class)
                ->setDisplay('name')
                ->setDataDepends(['user_id'])
                ->setLoadOptionsQueryPreparer(function ($element, $query) {
                    $user = \App\User::find($element->getDependValue('user_id'))->first();
                    return $query->where('sex', $user->sex);
                })
                ->required()
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
