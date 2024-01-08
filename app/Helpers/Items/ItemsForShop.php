<?php
namespace App\Helpers\Items;

use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Presenters\UserPresent;
use App\Models\ShopItem;
use App\Helpers\JoinSubjects as Subjects;

class ItemsForShop extends Items
{
    /**
     * @var string
     * Переменная содержит alias предмета
     */
    public string $subject;
    /**
     * @var array
     * Массив артефактов распределённый по предметамы
     */
    protected array $shop_items;

    public function __construct($user_id, UserPresent $user_present = null, string $can = null)

    {
        parent::__construct($user_id);

        //Добавляет дополнительное свойство $canEquip
        $this->artifacts = $this->getItemsWithCan($this->getArtifacts(), $user_present, $can, function ($item){return $item->artifact;});

        $subjects_alias = $user_present->getArrayKeysSubjects();
        $shop_items = $this->buildObjectItemForShop($subjects_alias);
        $this->setItemsForShop($shop_items);
    }
    /**
     * Фильтруем список артефактов по equip, надетые/ненадетые -> 1/0
     * $this->subject
     * @return Collection
     */
    public function getFilteredItems(): Collection{

        $subject_id = Subjects::getSubjectId($this->subject);
        $userClassTypeId = $this->user->property()->first()->type_id;

        //Фильтруем выбранные артефакты по дополнительной связи artifact->subjects и по типу класса учениках artifact->class_type_id
        return $this->artifacts->filter(function ($value) use ($userClassTypeId, $subject_id) {
            return ($value->artifact->subjects->contains('id', $subject_id)) && ($value->artifact->class_type_id === $userClassTypeId) || $value->artifact->class_type_id === 1;
        })->values();
    }
    /**
     * Получаем коллекцию всех артефактов ученика
     * @param User $user
     * @return Collection
     */
    public function getItems(User $user): Collection{

        //Берём артефакты из магазина со связью artifact->rarity()
        return ShopItem::with('artifact.rarity', 'artifact.artifact_trade', 'artifact.subjects', 'artifact.artifact_type')->get();
    }

    /**
     * Получаем коллекцию всех артефактов ученика
     * @param array $subjects_alias
     * @return array
     */
    public function buildObjectItemForShop(array $subjects_alias){
        $shop = [];
        foreach ($subjects_alias as $subject){
            $this->subject = $subject;

            $filtered_artifacts = $this->getFilteredItems();

            //Делаем фильтрацию объекта и добавляем html и описание stats
            $artifacts = $this->getArtifactsHtml($filtered_artifacts, function ($artifact){
                //Добавляем свойство quantity
                $artifact['artifact']['quantity'] = $artifact['quantity'];
                return $artifact['artifact'];
            });

            $shop[$subject] = $artifacts;
        }

        return $shop;
    }
    /**
     * Установить массив всех артефактов магазина
     * @param array $shop_items
     */
    public function setItemsForShop(array $shop_items){
        $this->shop_items = $shop_items;
    }
    /**
     * Получить массив всех артефактов магазина
     * @return array $shop_items
     */
    public function getItemsForShop(): array
    {
        return collect($this->shop_items)->map(function ($item){

            return collect($item)->map(function ($i){
                return collect($i)->except(['id', 'rarity_id', 'artifact_type_id', 'artifact_trade_id', 'pivot', 'slot_id', 'subjects', 'price', 'image', 'user_level', 'class_type_id']);
            });
        })->toArray();
    }

}