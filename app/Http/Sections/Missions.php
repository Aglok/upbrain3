<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use DB;

/**
 * Class Missions
 *
 * @property \App\Models\Mission $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Missions extends Section
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
                AdminColumn::text('subject_id', 'Предмет'),
                AdminColumn::text('progress_id', 'Достижения'),
                AdminColumn::text('level', 'Уровень')
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
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('subject_id', 'Предмет')
                ->setModelForOptions(\App\Models\Subject::class)
                ->setDisplay('name')->required(),
            AdminFormElement::select('progress_id', 'Достижения')
                ->setModelForOptions(\App\Models\Progress::class)
                ->setDisplay('name')->required(),
            AdminFormElement::text('level', 'Уровень'),
            AdminFormElement::multiselect('artifacts', 'Артефакты', \App\Models\Artifact::class)->setDisplay('name'),

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
