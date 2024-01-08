<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class UserActions
 *
 * @property \App\Models\UserAction $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class UserActions extends Section implements Initializable
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
     * Initialize class.
     */
    public function initialize()
    {
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('user.full_name', 'Ученик'),
                AdminColumn::text('number_current_move', 'Число ходов'),
                AdminColumn::text('actions', 'Список действий'),
            ]);

    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit(int $id = null, $payload = [])
    {
        return AdminForm::card()->addBody([
            AdminFormElement::text('user_id', 'Ученик'),
            AdminFormElement::text('number_current_move', 'Число ходов'),
            AdminFormElement::textarea('actions', 'Список действий'),
        ]);
    }

    /**
     * @param array $payload
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    /**
     * @param int $id
     * @return void
     */
    public function onRestore(int $id)
    {
        // remove if unused
    }
}
