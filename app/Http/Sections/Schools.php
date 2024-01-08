<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Schools
 *
 * @property School $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Schools extends Section
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
            ->with(['subjects'])
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumnEditable::text('name', 'Название'),
                AdminColumnEditable::select('district', 'Район')
                    ->setWidth('250px')
                    ->setEnum(['ЮЗАО', 'ЗАО', 'СЗАО', 'СВАО', 'ВАО', 'ЮАО', 'ЮВАО', 'САО', 'ЦАО'])
                    ->setTitle('Выберите район:'),
                AdminColumn::lists('subjects.name', 'Предметы')->setWidth('200px'),
                AdminColumnEditable::text('alias', 'Кратко'),
                AdminColumn::text('description', 'Описание')
            ]);
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit(int $id = null, array $payload = []): FormInterface
    {
        return AdminForm::card()->addBody([
            AdminFormElement::text('name', 'Имя')->required(),
            AdminFormElement::select('district', 'Район')->setEnum(['ЮЗАО', 'ЗАО', 'СЗАО', 'СВАО', 'ВАО', 'ЮАО', 'ЮВАО', 'САО', 'ЦАО']),
            AdminFormElement::text('alias', 'Кратко'),
            AdminFormElement::multiselect('subjects', 'Предметы', Subject::class)->setDisplay('name'),
            AdminFormElement::textarea('description', 'Описание')
        ]);
    }

    /**
     * @param array $payload
     * @return FormInterface
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
