<?php

namespace App\Helpers\Items;

use App\Presenters\UserPresent;
use Illuminate\Database\Eloquent\Collection;
use App\User;


class ItemsForProfile extends Items
{
    /**
     * @var int
     * Переменная определяет одет предмет или нет, 0 - не экипирован/ 1 - экипирован
     */
    public int $equip;

    public function __construct($user_id, $equip, UserPresent $user_present = null, string $can = null)
    {
        parent::__construct($user_id);
        $this->equip = $equip;

        //Фильтруем артефакты по $equip
        $artifacts = $this->getFilteredItems();

        //Добавляет дополнительное свойство $canEquip
        $artifactsCanBuy = $this->getItemsWithCan($artifacts, $user_present, $can);

        //Делаем фильтрацию объекта и добавляем html и описание stats
        $this->artifacts = $this->getArtifactsHtml($artifactsCanBuy);
    }

    /**
     * Фильтруем список артефактов по equip, надетые/ненадетые -> 1/0
     * $this->equip
     * @return Collection
     */
    public function getFilteredItems(): Collection{

        //Доработать filter поднять вверх после getArtifactsHtml
        return $this->artifacts->filter(function ($value) {
                return $value->pivot->equip === $this->equip;
        })->values();
    }

    /**
     * Получаем коллекцию всех артефактов ученика
     * @param User $user
     * @return Collection
     */
    public function getItems(User $user): Collection{

        return $user->artifacts()->with('rarity', 'artifact_type', 'artifact_trade', 'subjects')->get();
    }

}
