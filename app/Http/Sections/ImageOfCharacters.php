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
 * Class ImageOfCharacters
 *
 * @property \App\Models\ImageOfCharacter $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ImageOfCharacters extends Section
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
                AdminColumn::image('image', 'Изображение'),
                AdminColumn::link('name', 'Название'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::link('user_level', 'Уровень'),
                AdminColumn::link('class_person_id', 'Класс'),
                AdminColumn::link('sex', 'Пол'),
            ]);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $image_character = \App\Models\ImageOfCharacter::find($id);
        $dir = ($image_character->sex == 'M') ? 'man': 'woman';

        return AdminForm::panel()->addBody([
            AdminFormElement::text('name', 'Name')->required(),
            AdminFormElement::text('description', 'Description')->required(),
            AdminFormElement::image('image', 'Изображение')
                ->setUploadPath(function($file) use ($dir){
                    return 'images/characters/'.$dir.'/';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image'),
            AdminFormElement::text('user_level', 'Требуемый уровень'),
            AdminFormElement::select('class_person_id','Класс')
                ->setModelForOptions(\App\Models\ClassPerson::class)
                ->setDisplay('name'),
            AdminFormElement::select('sex', 'Пол')->setEnum(['M', 'W'])
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
