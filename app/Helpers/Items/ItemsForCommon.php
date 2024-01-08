<?php
/**
 * Created by PhpStorm.
 * User: artemperlov
 * Date: 2020-01-22
 * Time: 04:57
 */

namespace App\Helpers\Items;

use Illuminate\Database\Eloquent\Collection;
use App\User;


class ItemsForCommon extends Items
{

    public function __construct($user_id = null, Collection $artifacts = null)
    {
        if($user_id)
            parent::__construct($user_id);
        //Делаем фильтрацию объекта и добавляем html и описание stats
        if($artifacts){
            $this->artifacts = $this->getArtifactsHtml($artifacts);
        }
    }

    /**
     * Фильтруем список артефактов по equip, надетые/ненадетые -> 1/0
     * @return Collection
     */
    public function getFilteredItems(): Collection{}

    /**
     * Получаем коллекцию всех артефактов ученика
     * @param User $user
     * @return Collection
     */
    public function getItems(User $user): Collection{
        return $user->artifacts()->with('rarity', 'artifact_type', 'artifact_trade', 'subjects')->get();
    }

}
