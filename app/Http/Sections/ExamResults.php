<?php

namespace App\Http\Sections;

use function request;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use App\Helpers\Common;
use Storage;


/**
 * Class ExamResults
 *
 * @property \App\Models\ExamResult $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ExamResults extends Section
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
            ->with(['user', 'exam'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::link('user.full_name', 'Ученик'),
                AdminColumn::text('exam.name', 'Экзамен'),
                AdminColumn::custom('Баллы 1-12', function ($model){
                    return array_sum(explode(':', $model->result_short_answers));
                }),
                AdminColumn::custom('Баллы 13-19', function ($model){
                    return array_sum(explode(':', $model->result_expanded_answers));
                }),
                AdminColumn::custom('Ответы ученика', function ($model){
                    $arrAnswers = explode(':', $model->short_answers);
                    $html = '<ol>';
                    foreach ($arrAnswers as $answer):
                        $html .= '<li><b>'.$answer.'</b></li>';
                    endforeach;
                    $html .= '</ol>';
                    return $html;
                }),
                AdminColumn::text('comments', 'Комментарии'),
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
            $element_form_answers = AdminFormElement::html('<short-answers id='."$id".'></short-answers>', function ($model){
                $model->result_short_answers = request()->get('result_short_answers');
                $model->result_expanded_answers = request()->get('result_expanded_answers');
                $model->short_answers = request()->get('short_answers');
            });
        }else{
            $element_form_answers = AdminFormElement::html('<short-answers></short-answers>', function ($model){
                $model->result_short_answers = request()->get('result_short_answers');
                $model->result_expanded_answers = request()->get('result_expanded_answers');
                $model->short_answers = request()->get('short_answers');
            });
        }
        return AdminForm::panel()->addBody([

            $element_form_answers,
            AdminFormElement::select('exam_id', 'Экзамен', \App\Models\Exam::class)->setDisplay('name')->required(),
            AdminFormElement::select('user_id', 'Ученик')
                ->setModelForOptions(\App\User::class)
                ->setDisplay('full_name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query->where('active', '1');})
                ->required(),
            AdminFormElement::images('images','Изображения')
                ->setUploadPath(function($file) use ($id){
                    $full_name = Common::translit(\App\Models\ExamResult::find($id)->user->full_name);
                    $exam_id = \App\Models\ExamResult::find($id)->exam_id;
                    $dir = 'exams/math/v'.$exam_id.'/'.$full_name;

                    if (!Storage::disk('images')->exists($dir)) {
                        Storage::disk('images')->makeDirectory($dir);
                    }
                    return 'images/'.$dir;
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                })->storeAsJson(),
            AdminFormElement::text('comments', 'Комментарии'),
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
