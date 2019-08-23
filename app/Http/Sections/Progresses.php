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
 * Class Progresses
 *
 * @property \App\Models\Progress $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Progresses extends Section
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
                AdminColumn::link('rank', 'Уровень'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::link('list_count_tasks', 'Условие')
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

            AdminFormElement::image('image', 'Изображение')
                ->setUploadPath(function($file){
                return 'images/items/progress';
            })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image'),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::select('quality', 'Уровень', ['1' => 'Basic', '2' => 'Advanced', '3' => 'Master']),
            AdminFormElement::textarea('description', 'Описание'),
            AdminFormElement::text('list_count_tasks', 'Условие(Пример A:10, B:5)'),
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
