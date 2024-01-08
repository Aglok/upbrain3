<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use App\Models\Feature;
use App\Models\Mission;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Models\MonsterType;
use Exception;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Form\FormElements;

/**
 * Class Monsters
 *
 * @property \App\Models\Monster $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Monsters extends Section
{
    /**
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
     * @param array $payload
     *
     * @return DisplayInterface
     * @throws SelectException
     */
    public function onDisplay(array $payload = [])
    {
        return AdminDisplay::table()
            ->with(['features'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', ''),
                AdminColumnEditable::text('name', 'Название'),
                AdminColumnEditable::text('description', 'Описание'),
                AdminColumnEditable::select('monster_type_id', 'Тип монстра')
                    ->setWidth('250px')
                    ->setModelForOptions(MonsterType::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите тип:'),
                AdminColumnEditable::text('attack', 'Атака')->setModifier(function ($element) {
                    if(!is_null($element->getModelValue()))
                        return number_format($element->getModelValue(), 0, '.', ' ');
                }),
                AdminColumnEditable::text('critical_damage', 'Кр. атака'),
                AdminColumnEditable::text('critical_chance', 'Вероятность кр. атаки'),
                AdminColumnEditable::text('damage_min', 'Мин. урон'),
                AdminColumnEditable::text('damage_max', 'Макс. урон'),
                AdminColumnEditable::text('shield', 'Защита'),
                AdminColumnEditable::text('hp', 'Здоровье'),
                AdminColumnEditable::text('mp', 'Сила магии'),
                AdminColumnEditable::text('energy', 'Энергия'),
                AdminColumnEditable::text('monster_level', 'Уровень монстра'),
                AdminColumn::lists('features.title', 'Расширения')->setWidth('200px'),
            ]);
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     * @throws SelectException
     * @throws Exception
     */
    public function onEdit(int $id = null, array $payload = []): FormInterface
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::image('image', 'изображение')
                ->setUploadPath(function($file){
                    return 'images/items/monsters';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('monster_type_id', 'Тип монстра')
                ->setModelForOptions(MonsterType::class)
                ->setDisplay('name')
                ->required(),
            AdminFormElement::text('attack', 'Атака')->setDefaultValue(0),
            AdminFormElement::text('critical_damage', 'Кр. атака')->setDefaultValue(0),
            AdminFormElement::text('critical_chance', 'Вероятность кр. атаки')->setDefaultValue(0),
            AdminFormElement::text('shield', 'Защита')->setDefaultValue(0),
            AdminFormElement::text('damage_min', 'Мин. урон')->required()->setDefaultValue('5'),
            AdminFormElement::text('damage_max', 'Макс. урон')->required()->setDefaultValue('5'),
            AdminFormElement::text('hp', 'Здоровье')->setDefaultValue(0),
            AdminFormElement::text('mp', 'Магия')->setDefaultValue(0),
            AdminFormElement::text('energy', 'Энергия')->setDefaultValue(0),
            AdminFormElement::text('monster_level', 'Уровень монстра')->setDefaultValue(0),
            AdminFormElement::multiselect('features', 'Расширение', Feature::class)
                ->setDisplay('title')
        ]);

        $missions = AdminSection::getModel(Mission::class)->fireDisplay();

        $form->addBody([
            AdminFormElement::columns()->addColumn([
                $missions
            ])
        ]);


        $belongsTo = AdminForm::form()->addElement(
            new FormElements(
                [
                    AdminFormElement::belongsTo('monster_type', [
                        AdminFormElement::text('name', 'Тип')
                    ])
                ])
        );


        $tabs = AdminDisplay::tabbed([]);
        $tabs->appendTab($form, 'Свойства');
        $tabs->appendTab($belongsTo, 'Настройки');
        $tabs->appendTab($missions, 'Миссии');

        return $tabs;
    }

    /**
     * @param array $payload
     * @return FormInterface
     * @throws SelectException
     */
    public function onCreate(array $payload = []): FormInterface
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function isDeletable(Model $model): bool
    {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
