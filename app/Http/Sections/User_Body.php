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
 * Class User_Body
 *
 * @property \App\Models\User_Body $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class User_Body extends Section
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
                AdminColumn::custom('', function(\App\Models\User_Body $user_body) {

                    if($user_body->user->sex == 'M')
                        $image = $user_body->image_of_character->small_image_m;
                    else
                        $image = $user_body->image_of_character->small_image_w;

                    return '<a href="/'.$image.'" data-toggle="lightbox">
                    <img src="/'.$image.'" width="80px" class="thumbnail">
                    </a>';
                }),

                AdminColumn::link('image_of_character.name', 'Образ'),
                AdminColumn::link('user.full_name', 'Имя')
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
            AdminFormElement::select('image_of_character_id', 'Образ')
                ->setModelForOptions(\App\Models\Image_Of_Character::class)
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
