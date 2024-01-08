<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminForm;
use AdminFormElement;

/**
 * Class Pages
 *
 * @property \App\Models\Page $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Pages extends Section
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
        return AdminDisplay::tree()->setValue('title');
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();

        $tabs = AdminDisplay::tabbed([
            'Общее' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('title', 'Заголовок'),
                AdminFormElement::text('title_4U', 'Заголовок 4U'),
                AdminFormElement::text('style', 'Дополнительный стиль блока')->setHelpText('Прописать css внутри style=""'),
                AdminFormElement::text('style_title', 'Дополнительный стиль заголовока')->setHelpText('Прописать css внутри style=""'),
                AdminFormElement::text('style_title_4U', 'Дополнительный стиль заголовока 4U')->setHelpText('Прописать css внутри style=""'),
                AdminFormElement::text('keywords', 'Ключевые слова'),
                AdminFormElement::text('description', 'Описание'),
                AdminFormElement::text('link', 'ЧПУ - ссылка на станицу'),
                AdminFormElement::text('type', 'Тип страницы')->setHelpText('Webinar, Service, trial_exam, intensive_exam: будет влиять на форму оборатной связи и шаблон рассылки. <br> ege, oge: влияет на вывод блоков отдельных страниц'),
                AdminFormElement::checkbox('no_blocks_title', 'Убрать все заголоки'),
                AdminFormElement::checkbox('no_blocks', 'Убрать все блоки на странице'),
                AdminFormElement::text('class_image_header', 'css класс для шапки сайта'),
                AdminFormElement::multiselect('menus', 'Меню', \App\Models\Menu::class)
                    ->setDisplay('title')
                    ->setSortable(false),
                AdminFormElement::wysiwyg('text', 'Текст страницы', 'simplemde'),
            ]),
            'Блок с драконом' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::text('subject', 'Код предмета')->setHtmlAttribute('placeholder', 'math')->setHelpText('math, physics, russian, informatics, english, chemistry, history, biology, social_sciences: необходимо для отображени в блоках, где указывается наименование предмета'),
                AdminFormElement::text('subject_title', 'Название блока')->setHtmlAttribute('placeholder', 'Курсы ЕГЭ по ...'),
                AdminFormElement::image('subject_image', 'изображение с драконом')
                    ->setUploadPath(function($file){
                        return 'images/bg/subjects';
                    })
                    ->setUploadFileName(function($file){
                        return $file->getClientOriginalName();
                    }),
                AdminFormElement::textarea('subject_text', 'Текст с драконом')->setHtmlAttribute('placeholder', 'Наше обучение по математике снимает психологическую нагрузку, убирает стресс и поднимает настроение. Преподаватель всегда рядом, понятно объяснит и выстроит эффективный настрой в течение 2-3 недель.'),
            ])
        ]);

        $form->addBody($tabs);

        return $form;
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
