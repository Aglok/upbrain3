<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;


/**
 * Class Contacts
 *
 * @property \App\Models\Contact $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts extends Section
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
        return AdminDisplay::table()->
        setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '№'),
                AdminColumn::text('firstname', 'Имя'),
                AdminColumn::text('lastname', 'Фамилия'),
                AdminColumn::text('patronymic', 'Отчество'),
                AdminColumn::text('phone', 'Телефон'),
                AdminColumn::text('email', 'Почта'),
                AdminColumn::text('subjects', 'Предметы'),
                AdminColumn::text('type_of_training', 'Тип Обучения'),
                AdminColumn::text('hei', 'ВУЗ'),
                AdminColumn::text('place', 'Место'),
                AdminColumn::text('points', 'Баллы'),
                AdminColumn::text('additionally', 'Дополнительно'),
/*                AdminColumn::text('address', 'Адрес'),
                AdminColumn::text('friend', 'С другом'),
                AdminColumn::text('birthday', 'День рождения'),
                AdminColumn::text('comment', 'Комментарий'),*/
                AdminColumn::text('created_at', 'Создано')
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
            AdminFormElement::text('firstname', 'Имя'),
            AdminFormElement::text('lastname', 'Фамилия'),
            AdminFormElement::text('patronymic', 'Отчество'),
            AdminFormElement::text('phone', 'Телефон'),
            AdminFormElement::text('email', 'Почта'),
            AdminFormElement::text('subjects', 'Предметы'),
            AdminFormElement::text('type_of_training', 'Тип Обучения'),
            AdminFormElement::text('hei', 'ВУЗ'),
            AdminFormElement::text('place', 'Место'),
            AdminFormElement::text('points', 'Баллы'),
            AdminFormElement::text('additionally', 'Дополнительно'),
            AdminFormElement::text('address', 'Адрес'),
            AdminFormElement::text('friend', 'С другом'),
            AdminFormElement::text('birthday', 'День рождения'),
            AdminFormElement::text('comment', 'Комментарий')
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
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
