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
 * Class UserBodies
 *
 * @property \App\Models\UserBody $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserBodies extends Section
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
                AdminColumn::custom('', function(\App\Models\UserBody $user_body) {

                    //TODO::необходимо делать проверку на active в таблице user_body и показывать, только выбранный образ
                    //TODO::для этого добавление образов делать черех модель User, чтобы можно было обратиться к связям один ко многим
                    if($user_body->active == 1)
                        $image = $user_body->image_of_character->image;
                    else
                        $image = '';

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
        $body = \App\Models\UserBody::find($id);
        $sex = $body->user->sex;

        return AdminForm::panel()->addBody([
            AdminFormElement::select('user_id', 'Ученик')
                ->setModelForOptions(\App\User::class)
                ->setDisplay('full_name')->required(),
            AdminFormElement::select('image_of_character_id', 'Образ')
                ->setModelForOptions(\App\Models\ImageOfCharacter::class)
                ->setDisplay('name')->setLoadOptionsQueryPreparer(function($element, $query) use ($sex) {
                    return $query
                        ->where('sex', $sex);
                    })->required()
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
