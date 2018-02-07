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
 * Class Image_Of_Character
 *
 * @property \App\Models\Image_Of_Character $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Image_Of_Character extends Section
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
                AdminColumn::link('name', 'Название'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::image('big_image_m', 'Изображение М'),
                AdminColumn::image('big_image_w', 'Изображение Ж'),
                AdminColumn::link('user_level', 'Уровень'),
                AdminColumn::link('class_person_id', 'Класс'),
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
            AdminFormElement::text('name', 'Name')->required(),
            AdminFormElement::text('description', 'Description')->required(),
            AdminFormElement::image('small_image_m', 'Маленькое')
                ->setUploadPath(function($file){
                    return 'images/items/person/man/small';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('small_image_m'),
            AdminFormElement::image('big_image_m', 'Большое')
                ->setUploadPath(function($file){
                    return 'images/items/person/man/big';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminFormElement::image('small_image_w', 'Маленькое')
                ->setUploadPath(function($file){
                    return 'images/items/person/woman/small';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('small_image_w'),
            AdminFormElement::image('big_image_w', 'Большое')
                ->setUploadPath(function($file){
                    return 'images/items/person/woman/big';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminFormElement::text('user_level', 'Требуемый уровень'),
            AdminFormElement::select('class_person_id','Класс')
                ->setModelForOptions(\App\Models\Class_Person::class)
                ->setDisplay('name')
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
