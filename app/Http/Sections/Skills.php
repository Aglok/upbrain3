<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\ArtifactType;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use AdminColumnEditable;
use SleepingOwl\Admin\Section;

/**
 * Class Skills
 *
 * @property \App\Models\Skill $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Skills extends Section
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
     */
    public function onDisplay(array $payload = []): DisplayInterface
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumnEditable::text('name', 'Название'),
                AdminColumnEditable::text('description', 'Описание'),
                AdminColumnEditable::select('upgrade', 'Уровень навыка')
                    ->setWidth('250px')
                    ->setEnum([1,2,3])
                    ->setTitle('Выберите уровень:'),
                AdminColumnEditable::text('level', 'Уровень ученика'),
                AdminColumn::lists('features.title', 'Расширения')->setWidth('200px'),
            ]);
    }

    /**
     * @param null|int $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit(int $id = null, array $payload = []): FormInterface
    {
        return AdminForm::card()->addBody([
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::text('active', 'Актинвная'),
            AdminFormElement::text('description', 'Описание'),
            AdminFormElement::select('upgrade', 'Уровень навыка')
                ->setEnum([1,2,3]),
            AdminFormElement::text('level', 'Уровень ученика'),
            AdminFormElement::text('number_of_moves', 'Количесво ходов'),
//            AdminFormElement::select('skill_class_id', 'Класс')
//                ->setModelForOptions(SkillClass::class)
//                ->setDisplay('name'),
            AdminFormElement::select('type', 'Поведение навыка')->setEnum(['permanent', 'temporary','immediately']),
            AdminFormElement::multiselect('features', 'Расширение', Feature::class)
                ->setDisplay('title'),
            AdminFormElement::manyToMany('features', [
                AdminFormElement::select('target', 'На кого действует')->setEnum(['enemy', 'myself','all'])
            ])->setRelatedElementDisplayName('title')
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = []): FormInterface
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
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
