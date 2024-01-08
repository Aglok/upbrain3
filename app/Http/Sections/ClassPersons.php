<?php

namespace App\Http\Sections;

use AdminColumnEditable;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;


/**
 * Class ClassPersons
 *
 * @property \App\Models\ClassPerson $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ClassPersons extends Section
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
    protected $title = "Классы учеников";

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()->
        setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', 'Образ'),
                AdminColumnEditable::text('name', 'Name'),
                AdminColumnEditable::text('description', 'Описание'),
                AdminColumnEditable::text('attack', 'Атака'),
                AdminColumnEditable::text('shield', 'Защита'),
                AdminColumnEditable::text('damage_min', 'Мин. урон'),
                AdminColumnEditable::text('damage_max', 'Макс. урон'),
                AdminColumnEditable::text('hp', 'HP'),
                AdminColumnEditable::text('mp', 'Магия'),
                AdminColumnEditable::text('energy', 'Энергия'),
                AdminColumnEditable::text('critical_damage', 'Критический Урон'),
                AdminColumnEditable::text('critical_chance', 'Вероятность крита'),
                AdminColumnEditable::select('type_id', 'Тип класса', \App\Models\ClassType::class)->setDisplay('name'),
                AdminColumn::lists('progresses.name', 'Достижения')->setWidth('200px'),
                AdminColumn::lists('skills.name', 'Навыки')->setWidth('200px')
        ]);
    }

    /**
     * @param int $id
     * TODO::либо решить Observers метод creating()
     * @return FormInterface
     */
    public function onEdit(int $id)
    {
        if($id){
            $class_person = \App\Models\ClassPerson::find($id);
            $dir = ($class_person->sex == 'M') ? 'man': 'woman';
        }else
            $dir = '';

        return AdminForm::card()->addBody([
            AdminFormElement::image('image', 'Образ')
                ->setUploadPath(function($file) use ($dir) {
                return 'images/items/classes/'.$dir;
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image', 'Образ'),
            AdminFormElement::text('name', 'Название')->required(),
            AdminFormElement::wysiwyg('description', 'Описание')->setEditor('simplemde'),
            AdminFormElement::text('attack', 'Атака')->required()->setDefaultValue('10'),
            AdminFormElement::text('shield', 'Защита')->required()->setDefaultValue('10'),
            AdminFormElement::text('damage_min', 'Мин. урон')->required()->setDefaultValue('5'),
            AdminFormElement::text('damage_max', 'Макс. урон')->required()->setDefaultValue('5'),
            AdminFormElement::text('hp', 'HP')->required()->setDefaultValue('500'),
            AdminFormElement::text('mp', 'Магия')->required()->setDefaultValue('5'),
            AdminFormElement::text('energy', 'Энергия')->required()->setDefaultValue('40'),
            AdminFormElement::text('critical_damage', 'Критический Урон')->required()->setDefaultValue('30'),
            AdminFormElement::text('critical_chance', 'Вероятность крита')->required()->setDefaultValue('0.3'),
            AdminFormElement::select('sex', 'Пол')->setEnum(['M', 'W'])->required(),
            AdminFormElement::select('type_id', 'Тип', \App\Models\ClassType::class)->setDisplay('name'),
            AdminFormElement::multiselect('subjects', 'Предметы', \App\Models\Subject::class)
                ->setDisplay('name'),
            AdminFormElement::multiselectajax('progresses', 'Достижения')
                ->setModelForOptions(\App\Models\Progress::class)
                ->setDataDepends(['subjects'])
                ->setLoadOptionsQueryPreparer(function ($element, $query) {
                    return $query->where('subject_id', $element->getDependValue('subjects'));
                })
                ->setDisplay('name')
                ->setHelpText('Доступные достижения: основы, продвинутая, мастер'),
            AdminFormElement::multiselect('skills', 'Навыки', \App\Models\Skill::class)
                ->setDisplay('name'),
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
