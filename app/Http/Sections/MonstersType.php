<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminNavigation;
use App\Models\MonsterType;
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
 * Class MonstersType
 *
 * @property MonsterType $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class MonstersType extends Section implements Initializable
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
            $page = AdminNavigation::getPages()->findById('battle');
            $page->addPage($this->makePage(3)
                ->setTitle('Тип монстров')
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
            AdminColumn::link('name', 'Name', 'created_at')
                ->setSearchCallback(function($column, $query, $search){
                    return $query
                        ->orWhere('name', 'like', '%'.$search.'%')
                        ->orWhere('created_at', 'like', '%'.$search.'%')
                    ;
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
            ,
            AdminColumn::text('name', 'Monster Type'),
        ];

        $display = AdminDisplay::datatables()
            ->setOrder([[0, 'asc']])
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(MonsterType::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('name')
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
                AdminFormElement::text('name', 'Name')
                    ->required()
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
