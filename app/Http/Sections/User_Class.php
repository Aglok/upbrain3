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
 * Class User_Class
 *
 * @property \App\Models\User_Class $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class User_Class extends Section
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
                AdminColumn::custom('', function(\App\Models\User_Class $user_class) {

                    if($user_class->user->sex == 'M')
                        $image = $user_class->class_person->icon_man;
                    else
                        $image = $user_class->class_person->icon_woman;

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
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::select('user_id', 'Ученик')
                ->setModelForOptions(\App\User::class)
                ->setDisplay('full_name')->required(),
            AdminFormElement::select('class_person_id', 'Класс героя')
                ->setModelForOptions(\App\Models\Class_Person::class)
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
