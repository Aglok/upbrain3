<?php

namespace App\Http\Sections;

use AdminColumnEditable;
use App\Models\Artifact;
use App\Models\ArtifactType;
use App\Models\ClassType;
use App\Models\Feature;
use App\Models\Mission;
use App\Models\Progress;
use App\Models\Slot;
use App\Models\Subject;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminSection;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Form\FormElements;

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
    protected $title = "Артефакты в игре";

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     * @throws SelectException
     */
    public function onDisplay(): DisplayInterface
    {
        return AdminDisplay::table()
            ->with(['features'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', ''),
                //AdminColumnEditable::text('name', 'Название'),
                AdminColumnEditable::text('description', 'Описание'),
                AdminColumnEditable::select('artifact_type_id', 'Тип')
                    ->setWidth('250px')
                    ->setModelForOptions(ArtifactType::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите тип:'),
                AdminColumnEditable::select('slot_id', 'Тип слота')
                    ->setWidth('250px')
                    ->setModelForOptions(Slot::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите слот:'),
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
                AdminColumnEditable::select('rarity_id', 'Редкость')
                    ->setModelForOptions(\App\Models\Rarity::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите редкость:'),
                AdminColumnEditable::select('class_type_id', 'Класс')
                    ->setModelForOptions(ClassType::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите класс:'),
                AdminColumnEditable::select('progress_id', 'Прогресс')
                    ->setModelForOptions(Progress::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите достижения:'),
                AdminColumnEditable::text('user_level', 'Уровень'),
                AdminColumn::text('artifact_trade.gold', 'Цена'),
                AdminColumn::lists('features.title', 'Расширения')->setWidth('200px'),
                AdminColumn::lists('progresses.name', 'Достижения')->setWidth('200px'),
                AdminColumn::lists('subjects.name', 'Предметы')->setWidth('200px')
            ]);
    }

    /**
     * @return string
     * Функция принимает id артифакта и генерирует подкатегорию взависимости от типа артифакта
     * Директория для динамического создания подкатегории взависимости от типа артифакт
     *@var int $id
     */
    public function setArtifactDir(int $id): string
    {
        $type = Artifact::find($id)->artifact_type()->first();

        return $type->dir;
    }

    /**
     * @return FormInterface
     * @throws SelectException
     * @throws \Exception
     * @var int $id
     *
     */
    public function onEdit(int $id): FormInterface
    {
        //Для начала создается экземпляр без возможности указать директорию артефакта
        //Так как пока мы не знаем его тип
        //После создания при редактировании мы уже поставили тип и директория уже установлена
        //TODO::Vue компонент динамичная подгрудка dir, c ajax отправкой
        //TODO::setAfterSaveCallback Этот метод полезен когда нужно скорректировать логику сохранения изображений и привязываний их в модель
        //TODO::либо решить Observers метод creating()
        //TODO::После сохрания модели, если артефакт не будет привязан к классу в поле class_person_id должен быть 0, пока ставится NULL. Можено решить Observers
        if($id)
            $dir = $this->setArtifactDir($id);
        else
            $dir = '';

        $form = AdminForm::card()->addBody([
            AdminFormElement::image('image', 'изображение')
                ->setUploadPath(function($file) use ($dir) {
                    return 'images/items/artifacts/'.$dir;
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('slot_id', 'Тип слота')
                ->setModelForOptions(Slot::class)
                ->setDisplay('name')
                ->setHelpText('Выберите слот, чтобы указать тир артефакта')
                ->required(),
            AdminFormElement::selectajax('artifact_type_id', 'Тип артефакта')
                ->setModelForOptions(ArtifactType::class)
                ->setMinSymbols(1)
                ->setDataDepends(['slot_id'])
                ->setSearch(['name', 'dir'])
                ->setDisplay(function ($model) use ($dir) {
                    return $model->name . ' (id=' . $model->dir . ')';
                })->setLoadOptionsQueryPreparer(function ($element, $query) {
                    return $query->where('slot_id', $element->getDependValue('slot_id'));
                })->setHelpText('Тип: Книга, Меч, Топор, Посох, Арбалет, Лук, Доспех, Плащ, Щит, Браслет, Амулет, Стрелы')
                ->required(),
            AdminFormElement::text('attack', 'Атака')->setDefaultValue(0),
            AdminFormElement::text('critical_damage', 'Кр. атака')->setDefaultValue(0),
            AdminFormElement::text('critical_chance', 'Вероятность кр. атаки')->setDefaultValue(0),
            AdminFormElement::text('shield', 'Защита')->setDefaultValue(0),
            AdminFormElement::text('damage_min', 'Мин. урон')->setDefaultValue('0'),
            AdminFormElement::text('damage_max', 'Макс. урон')->setDefaultValue('0'),
            AdminFormElement::text('hp', 'Здоровье')->setDefaultValue(0),
            AdminFormElement::text('mp', 'Магия')->setDefaultValue(0),
            AdminFormElement::text('energy', 'Энергия')->setDefaultValue(0),
            AdminFormElement::text('rarity_id', 'Редкость')->setDefaultValue(0),
//            AdminFormElement::text('weight', 'Вес')->setDefaultValue(0),
            AdminFormElement::text('price', 'Цена')->setDefaultValue(0),
            AdminFormElement::multiselect('features', 'Расширение', Feature::class)
                ->setDisplay('title'),
            AdminFormElement::multiselect('subjects', 'Предметы', Subject::class)
                ->setDisplay('name'),
            AdminFormElement::multiselectajax('progresses', 'Достижения')
                ->setModelForOptions(Progress::class)
                ->setDataDepends(['subjects'])
                ->setLoadOptionsQueryPreparer(function ($element, $query) {
                    return $query->where('subject_id', $element->getDependValue('subjects'));
                })
                ->setDisplay('name')
                ->setHelpText('Доступные достижения: основы, продвинутая, мастер')
        ]);

        $missions = AdminSection::getModel(Mission::class)->fireDisplay();

        $form->addBody([
            AdminFormElement::columns()->addColumn([
                $missions
            ])
        ]);

        $manyToMany = AdminForm::form()->addElement(
            new FormElements(
                [
                    AdminFormElement::manyToMany('users', [
                        AdminFormElement::text('equip', 'Экипирован')
                    ])->setRelatedElementDisplayName(function ($model){
                        return $model->full_name;
                    })
                ])
        );

//        $morphToMany = AdminForm::form()->addElement(
//            new FormElements(
//                [
//                    AdminFormElement::manyToMany('features', [
//                    ])->setRelatedElementDisplayName('title')
//                ])
//        );

        $belongsTo = AdminForm::form()->addElement(
            new FormElements(
                [
                    AdminFormElement::belongsTo('artifact_type', [
                        AdminFormElement::text('name', 'Тип')
                    ]),
                    AdminFormElement::belongsTo('slot', [
                        AdminFormElement::text('name', 'Слот')
                    ]),
                    AdminFormElement::belongsTo('rarity', [
                        AdminFormElement::text('name', 'Редкость')
                    ])
                ])
        );

        $artifact_trade = AdminForm::form()->addElement(
            new FormElements(
                [
                    AdminFormElement::belongsTo('artifact_trade', [
                        AdminFormElement::hidden('artifact_id')->setHtmlAttribute('value', $id),
                        AdminFormElement::text('gold', 'Золото'),
                        AdminFormElement::number('crystal_red', 'Красный кристалл'),
                        AdminFormElement::number('crystal_blue', 'Синий кристалл'),
                        AdminFormElement::number('crystal_green', 'Зелёный кристалл'),
                        AdminFormElement::number('crystal_yellow', 'Жёлтый кристалл')
                    ])
                ])
        );

        $conditions = AdminForm::form()->addElement(new FormElements(
            [
                AdminFormElement::select('class_type_id', 'Класс')
                    ->setModelForOptions(ClassType::class)
                    ->setDisplay('name')
                    ->setHelpText('Выберите класс'),
                AdminFormElement::text('user_level', 'Уровень пользователя')->setDefaultValue(0),
                AdminFormElement::manyToMany('subjects', [
                    AdminFormElement::text('user_level', 'Уровень ученика')
                ])->setRelatedElementDisplayName(function ($model){
                    return $model->name;
                })
            ]
        ));

        $tabs = AdminDisplay::tabbed([]);
        $tabs->appendTab($form, 'Свойства');
        $tabs->appendTab($manyToMany, 'Пользователи');
        $tabs->appendTab($belongsTo, 'Настройки');
        $tabs->appendTab($artifact_trade, 'Стоимость');
        //$tabs->appendTab($morphToMany, 'Один ко многим через модель');
        $tabs->appendTab($conditions, 'Условия');
        $tabs->appendTab($missions, 'Миссии');

        return $tabs;
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
