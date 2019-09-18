<?php

namespace App\Http\Sections;

use App\Models\Artifact;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;

/**
 * Class Artifacts
 *
 * @property \App\Models\Artifact $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Artifacts extends Section
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
                AdminColumn::image('image', ''),
                AdminColumn::link('name', 'Название'),
                AdminColumn::link('description', 'Описание'),
                AdminColumn::link('artifact_type_id', 'Тип'),
                AdminColumn::link('slot_id', 'Тип слота'),
                AdminColumn::link('attack', 'Атака'),
                AdminColumn::link('damage', 'Урон'),
                AdminColumn::link('shield', 'Защита'),
                AdminColumn::link('hp', 'Здоровье'),
                AdminColumn::link('mp', 'Сила магии'),
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
     * @var int $id
     * @return string
     * Функция принимает id артифакта и генерирует подкатегорию взависимости от типа артифакта
     * Директория для динамического создания подкатегории взависимости от типа артифакт
     */
    public function setArtifactDir($id)
    {
        $type = Artifact::find($id)->artifact_type()->first();
        return $type->dir;
    }
    /**
     * @var int $id
     * @return FormInterface
     */
    public function onEdit($id)
    {
        //Для начала создается экземпляр без возможности указать директорию артефакта
        //Так как пока мы не знаем его тип
        //После создания при редактировании мы уже поставили тип и директория уже установлена
        //TODO::Vue компонент динамичкая подгрузка dir, c ajax отправкой
        //TODO::либо решить Observers метод creating()
        if($id)
            $dir = $this->setArtifactDir($id);
        else
            $dir = '';

        return AdminForm::panel()->addBody([
            AdminFormElement::image('image', 'изображение')
                ->setUploadPath(function($file) use ($dir) {
                    return 'images/items/artifacts/'.$dir;
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image', 'изображение'),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('slot_id', 'Тип слота')
                ->setModelForOptions(\App\Models\Slot::class)
                ->setDisplay('name')->required(),
            AdminFormElement::select('artifact_type_id', 'Тип артифакта')
                ->setModelForOptions(\App\Models\ArtifactType::class)
                ->setDisplay('name')->required(),
            AdminFormElement::text('attack', 'Атака'),
            AdminFormElement::text('shield', 'Защита'),
            AdminFormElement::text('damage', 'Урон'),
            AdminFormElement::text('hp', 'Здоровье'),
            AdminFormElement::text('mp', 'Магия'),
            AdminFormElement::text('energy', 'Энергия'),
//            AdminFormElement::text('increase_experience', 'Опыт'),
//            AdminFormElement::text('increase_gold', 'Золото'),
            AdminFormElement::text('rarity_id', 'Редкость'),
            AdminFormElement::text('weight', 'Вес'),
//            AdminFormElement::text('price', 'Цена'),
//            AdminFormElement::select('class_person_id', 'Класс героя')
//                    ->setModelForOptions(\App\Models\ClassPerson::class)
//                    ->setDisplay('name')->required(),
            AdminFormElement::multiselect('features', 'Расширение', \App\Models\Feature::class)
                    ->setModelForOptions(\App\Models\Feature::class)
                    ->setDisplay('title')->required(),
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
