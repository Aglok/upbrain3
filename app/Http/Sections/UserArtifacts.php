<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
/**
 * Class UserArtifacts
 *
 * @property \App\Models\UserArtifact $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserArtifacts extends Section
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
            ->setFilters([
                AdminDisplayFilter::related('artifact_id')->setModel(\App\Models\Artifact::class),
                AdminDisplayFilter::related('user_id')->setModel(\App\User::class)
            ])
            ->setColumns([
                AdminColumn::image('artifact.image', ''),
                AdminColumn::link('artifact.name', 'Артифакт')->append(AdminColumn::filter('artifact_id')),
                AdminColumn::link('user.full_name', 'Ученик')->append(AdminColumn::filter('user_id'))
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
            AdminFormElement::select('artifact_id', 'Артифакт')
                ->setModelForOptions(\App\Models\Artifact::class)
                ->setDisplay('name')->required(),
            AdminFormElement::select('user_id', 'Образ')
                ->setModelForOptions(\App\User::class)
                ->setDisplay('full_name')->required()
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
