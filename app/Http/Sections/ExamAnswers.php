<?php

namespace App\Http\Sections;

use function explode;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;


/**
 * Class ExamAnswers
 *
 * @property \App\Models\ExamAnswer $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ExamAnswers extends Section
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
            ->with(['exam'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::link('exam.name', 'Экзамен'),
                AdminColumn::custom('Ответы', function ($model){
                    $arrAnswers = explode(':', $model->exam_answers);
                    $html = '<ol>';
                    foreach ($arrAnswers as $answer):
                        $html .= '<li><b>'.$answer.'</b></li>';
                    endforeach;
                    $html .= '</ol>';
                    return $html;
                })
            ]);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        if($id){
            $element_form_answers = AdminFormElement::html('<exam_answers id='."$id".'></exam_answers>', function ($model){
                $model->exam_answers = request()->get('exam_answers');
            });
        }else{
            $element_form_answers = AdminFormElement::html('<exam_answers></exam_answers>', function ($model){
                $model->exam_answers = request()->get('exam_answers');
            });
        }
        return AdminForm::panel()->addBody([

            AdminFormElement::select('exam_id', 'Экзамен', \App\Models\Exam::class)->setDisplay('name')->required(),
            //AdminFormElement::text('exam_answers', 'Ответы')
            $element_form_answers
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
