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
 * Class Features
 *
 * @property \App\Models\Feature $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Features extends Section

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
                AdminColumn::image('image', ''),
                AdminColumn::link('title', 'Название'),
                AdminColumn::link('description', 'Описание'),
                AdminColumn::link('upgrade', 'Улучшение'),
                AdminColumn::link('value', 'Значение'),
                AdminColumn::text('type', 'Тип расширения'),
                AdminColumn::text('modification', 'Модификатор'),
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
            AdminFormElement::image('image', 'изображение')
                ->setUploadPath(function($file){
                    return 'images/items/features/';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image', 'изображение'),
            AdminFormElement::text('title', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::text('upgrade', 'Улучшение'),
            AdminFormElement::text('value', 'Значение'),
            AdminFormElement::select('type', 'Тип')
                ->setEnum(['experience_increase', 'experience_decrease' ,'hp_increase', 'hp_decrease', 'condition']),
            AdminFormElement::text('modification', 'Модификатор')
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
