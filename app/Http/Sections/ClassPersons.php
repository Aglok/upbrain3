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
        return AdminDisplay::table()->
        setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', 'Образ'),
                AdminColumn::link('name', 'Name'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::link('attack', 'Атака'),
                AdminColumn::link('shield', 'Защита'),
                AdminColumn::link('damage', 'Урон'),
                AdminColumn::link('hp', 'HP'),
                AdminColumn::link('mp', 'Магия'),
                AdminColumn::link('energy', 'Энергия'),
                AdminColumn::link('critical_damage', 'Критический Урон'),
                AdminColumn::link('critical_chance', 'Вероятность крита'),
        ]);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    //TODO::либо решить Observers метод creating()
    //
    public function onEdit($id)
    {
        if($id){
            $class_person = \App\Models\ClassPerson::find($id);
            $dir = ($class_person->sex == 'M') ? 'man': 'woman';
        }else
            $dir = '';

        return AdminForm::panel()->addBody([
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
            AdminFormElement::text('damage', 'Урон')->required()->setDefaultValue('5'),
            AdminFormElement::text('hp', 'HP')->required()->setDefaultValue('500'),
            AdminFormElement::text('mp', 'Магия')->required()->setDefaultValue('5'),
            AdminFormElement::text('energy', 'Энергия')->required()->setDefaultValue('40'),
            AdminFormElement::text('critical_damage', 'Критический Урон')->required()->setDefaultValue('30'),
            AdminFormElement::text('critical_chance', 'Вероятность крита')->required()->setDefaultValue('0.3'),
            AdminFormElement::select('sex', 'Пол')->setEnum(['M', 'W'])->required()

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
