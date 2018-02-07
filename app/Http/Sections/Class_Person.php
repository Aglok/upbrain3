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
 * Class Class_Person
 *
 * @property \App\Models\Class_Person $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Class_Person extends Section
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
                AdminColumn::image('icon_man', 'icon_man'),
                AdminColumn::image('icon_woman', 'icon_woman'),
                AdminColumn::link('name', 'Name'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::link('attack', 'Атака'),
                AdminColumn::link('defense', 'Защита'),
                AdminColumn::link('magic', 'Магия'),
                AdminColumn::link('energy', 'Энергия'),
                AdminColumn::link('health_point', 'HP'),
                AdminColumn::link('increase_experience', '^опыт'),
                AdminColumn::link('increase_gold', '^золото'),
                AdminColumn::link('skill_1_id', 'Навык 1'),
                AdminColumn::link('skill_2_id', 'Навык 2'),
                AdminColumn::link('skill_3_id', 'Навык 3'),
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
            AdminFormElement::image('icon_man', 'icon_man')
                ->setUploadPath(function($file){
                return 'images/items/classes/man';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('icon_man', 'icon_man'),
            AdminFormElement::image('icon_woman', 'icon_woman')
                ->setUploadPath(function($file){
                return 'images/items/classes/woman';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('icon_woman', 'icon_woman'),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::wysiwyg('description', 'Описание')->setEditor('simplemde'),
            AdminFormElement::text('attack', 'Атака'),
            AdminFormElement::text('defense', 'Защита'),
            AdminFormElement::text('magic', 'Магия'),
            AdminFormElement::text('energy', 'Энергия'),
            AdminFormElement::text('health_point', 'HP'),
            AdminFormElement::text('increase_experience', '^опыт'),
            AdminFormElement::text('increase_gold', '^золото'),
            AdminFormElement::text('skill_1_id', 'Навык 1'),
            AdminFormElement::text('skill_2_id', 'Навык 2'),
            AdminFormElement::text('skill_3_id', 'Навык 3'),
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
