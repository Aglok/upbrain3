<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminSection;

/**
 * Class SetOfTaskMaths
 *
 * @property \App\Models\SetOfTaskMath $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class SetOfTaskMaths extends Section
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
    protected $title = "Набор задач";

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {

        $display = AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '№'),
                AdminColumn::custom('Название', function ($model){
                    return "<a href=\"".url('admin/process/math/'.$model->id)."\">".$model->name."</a>";
                }),
//              AdminColumn::image('image', 'Изображение'),
//              AdminColumn::link('name', 'Название'),
//              AdminColumn::link('alias', 'Кратко'),
//              AdminColumn::link('set_of_task_type.name', 'Тип'),
                AdminColumn::custom('Количество задач', function ($model){
                    return count($model->tasks);
                }),
                AdminColumn::custom('Сумма монет', function ($model){
                    return $model->tasks->sum('experience');
                }),
                AdminColumn::custom('Суммарный опыт', function ($model){
                    return $model->tasks->sum('gold');
                }),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::custom('pdf', function($model) {
                    return "<a href=\"".route('pdfviewtasks', ['id' => $model->id, 'subject' => 'math', 'tasks' => 'pdf', 'sum_exp' => $model->tasks->sum('experience'),'sum_gold' => $model->tasks->sum('gold'), 'count' => count($model->tasks)])."\">Скачать PDF</a>";
                })->setWidth('150px'),
                AdminColumn::custom('pdf', function($model) {
                    return "<a href=\"".route('pdfviewlist', ['id' => $model->id, 'subject' => 'math', 'list' => 'pdf', 'sum_exp' => $model->tasks->sum('experience'),'sum_gold' => $model->tasks->sum('gold'), 'count' => count($model->tasks)])."\">Скачать Ведомость</a>";
                })->setWidth('150px')
            ])->paginate(100);


        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
//        $this->updating(function($config, $model) {
//            return false;
//        });
        return AdminForm::panel()->addBody([

            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('alias', 'Кратко'),
            AdminFormElement::image('image', 'Рис'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('type', 'Тип', \App\Models\SetOfTaskType::class)->setDisplay('name'),
            AdminSection::getModel(\App\Models\TaskMath::class)
                ->fireDisplay(
                    ['scopes' => ['withSetOfTask', $id]]
            )
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
