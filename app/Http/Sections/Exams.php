<?php

namespace App\Http\Sections;

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamSubject;
use App\User;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use Illuminate\Database\Eloquent\Model;

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
                AdminColumnEditable::datetime('start_date', 'Дата экзамена')->setFormat('d.m.Y H:i')
            ]);

    }

    /**
     * @param int $id
     *
     * @return FormInterface
     * @throws SelectException
     */
    public function onEdit(int $id): FormInterface
    {
        return AdminForm::card()->addBody([

//            AdminFormElement::select('exam_subject_id', 'Предмет')
//                ->setModelForOptions(ExamSubject::class)
//                ->setDisplay('name')->required(),
//            AdminFormElement::text('name', 'Кратко'),
//            AdminFormElement::text('description', 'Описание'),
//            AdminFormElement::text('type', 'Тип экзамена'),
//            AdminFormElement::datetime('start_date', 'Дата экзамена')->setFormat('Y-m-d H:i:s')->setPickerFormat('d.m.y h:i'),
/*            AdminFormElement::hasMany('exam_results', [
                AdminFormElement::columns([
                    [AdminFormElement::text('result_short_answers', 'result_short_answers')],
                    [AdminFormElement::number('user_id', 'id пользователя')],
                    [AdminFormElement::custom()->setDisplay(function($model){
                        return '<div>'.$model->id.'</div>';
                    })],
                    [AdminFormElement::images('images', 'Изображения')]
                ])
            ]),*/
            AdminFormElement::hasMany('exam_results', [
                //AdminFormElement::text('result_short_answers', 'result_short_answers'),
                //AdminFormElement::number('user_id', 'id пользователя'),
//                AdminFormElement::custom()->setDisplay(function($model){
//                    return '<div>'.$model->user_id.'</div>';
//                }),
//                AdminFormElement::images('images', 'Изображения'),
//                AdminFormElement::select('exam_id', 'Экзамен')
//                    ->setModelForOptions(Exam::class, 'name'),
//
//                //Не работает так как обращается к не модели Exam, а к модели ExamResult
//                AdminFormElement::dependentselect('exam_answer_id', 'Ответы')
//                    ->setModelForOptions(ExamAnswer::class, 'exam_answers')
//                    ->setDataDepends(['exam_id'])
//                    ->setLoadOptionsQueryPreparer(function($item, $query) {
//                        return $query->where('exam_id', $item->getDependValue('exam_id'));
//                    }),
                AdminFormElement::multiselect('exam_examiners', 'Экзаменаторы', User::class)
                ->setDisplay('full_name'),

            ]),
//            AdminFormElement::multiselect('exam_examiners', 'Экзаменаторы', User::class)
//                ->setDisplay('full_name'),
//            AdminFormElement::select('exam_id', 'Экзамен')
//                ->setModelForOptions(Exam::class, 'name'),
//            AdminFormElement::dependentselect('exam_answer_id', 'Ответы')
//                ->setModelForOptions(ExamAnswer::class, 'exam_answers')
//                ->setDataDepends(['exam_id'])
//                ->setLoadOptionsQueryPreparer(function($item, $query) {
//                    return $query->where('exam_id', $item->getDependValue('exam_id'));
//                })
        ]);
    }

    /**
     * @return FormInterface
     * @throws SelectException
     */
    public function onCreate(): FormInterface
    {
        return $this->onEdit((int)null);
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
