<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminNavigation;
use App\Models\UserNewsletter;
use Exception;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class UserNewsletters
 *
 * @property UserNewsletter $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class UserNewsletters extends Section implements Initializable
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
    public function initialize(): void
    {
        app()->booted(function() {
            $page = AdminNavigation::getPages()->findById('users');
            $page->addPage($this->makePage(3)
                ->setTitle('Письма учеников')
                ->setIcon('far fa-dot-circle nav-icon')
                ->setAccessLogic(function() {
                    return auth()->user()->isSuperAdmin();}));
        });
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     * @throws SelectException
     */
    public function onDisplay(array $payload = []): DisplayInterface
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('user_id', 'id ученика')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('newsletter_id', 'id письма')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::datetime('created_at', 'Дата создания')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::datetime('updated_at', 'Дата обновления')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setOrder([[0, 'asc']])
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(UserNewsletter::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('user_id')
                ->setColumnName('user_id')
                ->setPlaceholder('All names')
            ,
        ]);
        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     * @throws Exception
     */
    public function onEdit(int $id = null, array $payload = []): FormInterface
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('user_id', 'id ученика')->required(),
                AdminFormElement::text('newsletter_id', 'id письма')->required(),
                AdminFormElement::html('<hr>'),
                AdminFormElement::datetime('created_at')
                    ->setVisible(true)
                    ->setReadonly(false)
            ])
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @param array $payload
     * @return FormInterface
     * @throws Exception
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
