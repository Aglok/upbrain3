<?php

namespace App\Http\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use App\Role;
/**
 * Class Posts
 *
 * @property \App\Models\Post $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Posts extends Section
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
        return AdminDisplay::table()->setApply(function($query) { $query->orderBy('created_at', 'desc'); })
            ->with('tags')
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', 'Изображение'),
                AdminColumnEditable::text('alt', 'Подпись изображения'),
                AdminColumnEditable::text('title', 'Заголовок'),
                AdminColumnEditable::text('cut', 'Тизер'),
                AdminColumn::text('user.full_name', 'Автор'),
                AdminColumnEditable::checkbox('published', 'Опубликован'),
                AdminColumn::lists('tags.name', 'Теги')->setWidth('200px')
            ]);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()
            ->addHeader([AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::image('image', 'Изображение')
                        ->setUploadPath(function($file){
                            return 'images/blog';
                        })
                        ->setUploadFileName(function($file){
                            return $file->getClientOriginalName();
                        })
                ],5)
                ->addColumn([
                    AdminFormElement::checkbox('published', 'Опубликовать'), AdminColumn::image('image', 'Изображение'), AdminFormElement::text('alt', 'Подпись изображения')
                ],5)
            ])
            ->addBody([AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::select('user_id', 'Автор')
                        ->setModelForOptions(\App\User::class)
                        ->setDisplay('full_name')->setLoadOptionsQueryPreparer(function($element, $query) {
                            //Получаем модель role со связью belongToMany и через plunk($id) формируем коллекцию массив по полю id
                            $role = Role::where('name',  'author')->firstOrFail();
                            $id = $role->users()->pluck('id')->all();
                            return $query->whereIn('id', $id);
                        })->required(),
                    AdminFormElement::text('keywords', 'Ключевые слова')]
                    , 5)
                ->addColumn([
                    AdminFormElement::text('description', 'Описание'),
                    AdminFormElement::text('link', 'Ссылка на английском')
                    ],5)
            ])
            ->addFooter([
                AdminFormElement::multiselect('tags', 'Теги', \App\Models\Tag::class)->setDisplay('name'),
                AdminFormElement::text('title', 'Заголовок'),
                AdminFormElement::wysiwyg('text', 'Текст блога', 'simplemde')
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
