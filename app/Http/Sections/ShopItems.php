<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
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
 * Class ShopItems
 *
 * @property \App\Models\ShopItem $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ShopItems extends Section
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
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::image('artifact.image'),
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('artifact.name', 'Артифакт'),
            AdminColumn::text('artifact.artifact_type.name', 'Тип')->setHtmlAttribute('class', 'text-center'),
            AdminColumnEditable::text('artifact.price', 'Монет')->setModifier(function ($element){
                if(!is_null($element->getModelValue()))
                    return number_format($element->getModelValue(), 0, '.', ' ');
            })->setHtmlAttribute('class', 'text-center'),
            AdminColumnEditable::text('quantity', 'Количество')->setHtmlAttribute('class', 'text-center')
        ];

        $display = AdminDisplay::datatables()
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

//        $display->setColumnFilters([
//            AdminColumnFilter::select()
//                ->setModelForOptions(\App\Models\ShopItem::class, 'name')
//                ->setLoadOptionsQueryPreparer(function($element, $query) {
//                    return $query;
//                })
//                ->setDisplay('name')
//                ->setColumnName('name')
//                ->setPlaceholder('All names')
//            ,
//        ]);
//        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('artifact_id', 'Выберите артифакт', \App\Models\Artifact::class)
                    ->setDisplay('name')
                    ->required(),
                AdminFormElement::number('quantity', 'Кол-во')
                    ->setDefaultValue(1)
                    ->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
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
     * @return FormInterface
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
