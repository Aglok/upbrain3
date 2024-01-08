<?php

namespace App\Http\Sections;

use AdminColumnEditable;
use AdminDisplay;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminForm;
use AdminFormElement;

/**
 * Class Actions
 *
 * @property \App\Models\Action $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Actions extends Section
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
    public function onDisplay($payload = [])
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumnEditable::text('name', 'Название'),
                AdminColumnEditable::select('action_type_id', 'Тип действия')
                    ->setWidth('250px')
                    ->setModelForOptions(\App\Models\ActionType::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите тип:')
            ]);
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     * @throws SelectException
     */
    public function onEdit(int $id = null, $payload = [])
    {
        return AdminForm::card()->addBody([
            AdminFormElement::text('name', 'Название'),
            AdminFormElement::select('action_type_id', 'Тип действия')
                ->setModelForOptions(\App\Models\ActionType::class)
                ->setDisplay('name')
        ]);
    }

    /**
     * @param array $payload
     * @return FormInterface
     * @throws SelectException
     */
    public function onCreate($payload = [])
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
