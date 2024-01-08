<?php

namespace App\Http\Sections;

use AdminSection;
use App\Models\Artifact;
use App\Models\Mission;
use App\Models\Monster;
use App\Models\TaskMath;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;

/**
 * Class Missions
 *
 * @property Mission $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Missions extends Section
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
     * @throws SelectException
     */
    public function onDisplay(): DisplayInterface
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumnEditable::text('name', 'Название'),
                AdminColumnEditable::text('description', 'Описание'),
                AdminColumnEditable::select('subject_id', 'Предмет')
                    ->setWidth('250px')
                    ->setModelForOptions(\App\Models\Subject::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите предмет'),
                AdminColumnEditable::select('progress_id', 'Достижения')
                    ->setWidth('250px')
                    ->setModelForOptions(\App\Models\Progress::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите достижение'),
                AdminColumnEditable::text('user_level', 'Уровень'),
                AdminColumnEditable::select('monster_id', 'Монстр')
                    ->setWidth('250px')
                    ->setModelForOptions(Monster::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите монстра'),
                AdminColumn::lists('artifacts.name', 'Артифакты')->setWidth('200px'),
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
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('subject_id', 'Предмет')
                ->setModelForOptions(\App\Models\Subject::class)
                ->setDisplay('name')->required(),
            AdminFormElement::select('progress_id', 'Достижения')
                ->setModelForOptions(\App\Models\Progress::class)
                ->setDisplay('name')->required(),
            AdminFormElement::text('user_level', 'Уровень'),
            AdminFormElement::multiselect('artifacts', 'Артефакты', Artifact::class)->setDisplay('name'),
            AdminFormElement::select('monster_id', 'Монстр', Monster::class)->setDisplay('name'),

            //Посылаем запрос в таблицу TaskMath для отображения задач, данной модели Mission
            AdminSection::getModel(TaskMath::class)
                ->fireDisplay(
                    ['scopes' => ['withMission', $id]]
                )
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
