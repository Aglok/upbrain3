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
 * Class Artifact
 *
 * @property \App\Models\Artifact $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Artifact extends Section
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
     * Директория для динамического создания подкатегории взависимости от типа артифакта
     * @var string
     */
    protected $dir;
    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', ''),
                AdminColumn::link('name', 'Название'),
                AdminColumn::link('description', 'Описание'),
                AdminColumn::link('artifact_type_id', 'Тип'),
                AdminColumn::link('user_level', 'Уровень'),
                AdminColumn::link('attack', 'Атака'),
                AdminColumn::link('damage_min', 'Мин. урон'),
                AdminColumn::link('damage_max', 'Макс. урон'),
                AdminColumn::link('defense', 'Защита'),
                AdminColumn::link('magic', 'Магия'),
                AdminColumn::link('energy', 'Энергия'),
                AdminColumn::link('increase_experience', 'Опыт'),
                AdminColumn::link('increase_gold', 'Золото'),
                AdminColumn::link('rarity_id', 'Редкость'),
                AdminColumn::link('weight', 'Вес'),
                AdminColumn::link('price', 'Цена'),
                AdminColumn::link('class_person_id', 'Класс героя'),
            ]);
    }

    /**
     * @param int $id
     * Функция принимает id артифакта и генерирует подкатегорию взависимости от типа артифакта
     */
    public function setArtifactDir($id)
    {
        $this->dir = DB::table('artifacts_type')->where('id', $id)->value('dir');
    }
    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $this->setArtifactDir($id);

        return AdminForm::panel()->addBody([
            AdminFormElement::image('image', 'изображение')
                ->setUploadPath(function($file){
                    return 'images/items/artifacts/'.$this->dir;
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image', 'изображение'),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('artifact_type_id', 'Тип артифакта')
                ->setModelForOptions(\App\Models\Artifact_Type::class)
                ->setDisplay('name')->required(),
            AdminFormElement::text('user_level', 'Уровень'),
            AdminFormElement::text('attack', 'Атака'),
            AdminFormElement::text('damage_min', 'Мин. урон'),
            AdminFormElement::text('damage_max', 'Макс. урон'),
            AdminFormElement::text('defense', 'Защита'),
            AdminFormElement::text('magic', 'Магия'),
            AdminFormElement::text('energy', 'Энергия'),
            AdminFormElement::text('increase_experience', 'Опыт'),
            AdminFormElement::text('increase_gold', 'Золото'),
            AdminFormElement::text('rarity_id', 'Редкость'),
            AdminFormElement::text('weight', 'Вес'),
            AdminFormElement::text('price', 'Цена'),
            AdminFormElement::select('class_person_id', 'Класс героя')
                    ->setModelForOptions(\App\Models\Class_Person::class)
                    ->setDisplay('name')->required(),
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
