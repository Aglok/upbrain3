<?php

namespace App\Http\Sections;

use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\ArtifactTrade;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Exceptions\Form\Element\SelectException;
use SleepingOwl\Admin\Section;

/**
 * Class ArtifactsTrade
 *
 * @property ArtifactTrade $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ArtifactsTrade extends Section implements Initializable
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
        //$this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     * @throws SelectException
     */
    public function onDisplay(array $payload = []): DisplayInterface
    {
        return AdminDisplay::table()
            ->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumnEditable::select('artifact_id', 'Артефакт')
                    ->setWidth('250px')
                    ->setModelForOptions(\App\Models\Artifact::class)
                    ->setDisplay('name')
                    ->setTitle('Выберите артефакт:'),
                AdminColumnEditable::text('gold', 'Цена'),
                AdminColumnEditable::text('crystal_red', 'Красный кристалл'),
                AdminColumnEditable::text('crystal_blue', 'Синий кристалл'),
                AdminColumnEditable::text('crystal_green', 'Зелёный кристалл'),
                AdminColumnEditable::text('crystal_yellow', 'Жёлтый кристалл')
            ]);
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     * @throws SelectException
     */
    public function onEdit(int $id = null, array $payload = []): FormInterface
    {

        return AdminForm::card()->addBody([
            AdminFormElement::selectajax('artifact_id', 'Артефакт')
                ->setModelForOptions(\App\Models\Artifact::class)
                ->setDisplay('name'),
            AdminFormElement::number('gold', 'Цена'),
            AdminFormElement::number('crystal_red', 'Красный кристалл'),
            AdminFormElement::number('crystal_blue', 'Синий кристалл'),
            AdminFormElement::number('crystal_green', 'Зелёный кристалл'),
            AdminFormElement::number('crystal_yellow', 'Жёлтый кристалл')
        ]);
    }

    /**
     * @param array $payload
     * @return FormInterface
     * @throws SelectException
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
