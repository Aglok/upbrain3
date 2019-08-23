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
 * Class Exams
 *
 * @property \App\Models\Exam $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Exams extends Section
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
            ->with(['exam_subject'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::link('exam_subject.name', 'Предмет'),
                AdminColumn::text('name', 'Кратко'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::text('type', 'Тип экзамена'),
                AdminColumn::datetime('start_date', 'Дата экзамена')->setFormat('d.m.Y H:i')
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

            AdminFormElement::select('exam_section_id', 'Предмет')
                ->setModelForOptions(\App\Models\ExamSubject::class)
                ->setDisplay('name')->required(),
            AdminFormElement::text('name', 'Кратко'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::text('type', 'Тип экзамена'),
            AdminFormElement::datetime('start_date', 'Дата экзамена')->setFormat('Y-m-d H:i:s')->setPickerFormat('d.m.y h:i')
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
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
