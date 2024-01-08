<?php

namespace App\Http\Sections;

use App\Models\ClassPerson;
use App\Models\ImageOfCharacter;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;

/**
 * Class ImageOfCharacters
 *
 * @property ImageOfCharacter $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ImageOfCharacters extends Section
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
    public function onDisplay(): DisplayInterface
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::image('image', 'Изображение'),
                AdminColumn::link('name', 'Название'),
                AdminColumn::text('description', 'Описание'),
                AdminColumn::link('user_level', 'Уровень'),
                AdminColumn::link('class_person_id', 'Класс'),
                AdminColumn::link('sex', 'Пол'),
            ]);
    }

    /**
     * @return FormInterface
     *@throws SelectException
     * @var int $id
     */
    public function onEdit(int $id): FormInterface
    {
        //Для начала создается экземпляр без возможности указать директорию 'man' или 'woman'
        //Так как пока мы не знаем пол образа
        //После создания при редактировании мы сможем поставить пол, так как директория уже установилась
        //TODO::либо решить Observers метод creating()
        if($id){
            $image_character = ImageOfCharacter::find($id);
            $dir = ($image_character->sex == 'M') ? 'man': 'woman';
        }else
            $dir = '';

        return AdminForm::card()->addBody([
            AdminFormElement::text('name', 'Name')->required(),
            AdminFormElement::text('description', 'Description')->required(),
            AdminFormElement::image('image', 'Изображение')
                ->setUploadPath(function($file) use ($dir){
                    return 'images/items/characters/'.$dir.'/';
                })
                ->setUploadFileName(function($file){
                    return $file->getClientOriginalName();
                }),
            AdminColumn::image('image'),
            AdminFormElement::text('user_level', 'Требуемый уровень'),
            AdminFormElement::select('sex', 'Пол')->setEnum(['M', 'W']),
            AdminFormElement::dependentselect('class_person_id','Класс')
                ->setModelForOptions(ClassPerson::class)
                ->setDataDepends(['sex'])
                ->setDisplay('name')
                ->setLoadOptionsQueryPreparer(function ($element, $query) {
                    return $query->where('sex', $element->getDependValue('sex'));
                })
                ->setHelpText('Доступные классы: маг, воин, целитель, критовик, интегратор')
        ]);
    }

    /**
     * @return FormInterface
     * @throws SelectException
     */
    public function onCreate(): FormInterface
    {
        return $this->onEdit((int)null);
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
