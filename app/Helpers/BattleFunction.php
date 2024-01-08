<?php

namespace App\Helpers;

use App\Helpers\UserInterface as UserI;
use App\Models\Monster;
use App\Models\UserProperty;
use App\Models\MonsterProperty;
use Illuminate\Support\Collection;


class BattleFunction
{
    /**
     * Функции уже учитывают параметры защиты, monster->skill, monster->spell, user->skill, user->spell, monster_property, user_property
     * Например: ActionAttack() - нужно учитывать надбавленные параметры урона и защиты от spell и skill монстра и героя.
     * Так как мы уже заранее просчитываем урон и защиту, прежде чем выводить на экран.
     **/


    /**
     * Функция возращает урон в зависимости от действия юнит
     *  @param UserProperty $user_property
     *  @param MonsterProperty $monster_property
     *  @param Collection $user_skills
     *  @param Collection $monster_skills
     * @return object
    **/
    static function ActionAttack(UserProperty $user_property, MonsterProperty $monster_property, Collection $user_skills, Collection $monster_skills) : object{

        $modify_user_property = static::ModifyProperty($user_property, $user_skills);
    }

    /**
     * Функция определяет математичекую операцию, взависимости от $features->type, уменьшение/увеличения характеристик героя или монстра
     * Возможность увеличения/уменьшения характеристик будет зависеть активного навыка и количества ходов $active и $number_of_moves
     * Возвращает объект коэффициентов увеличения или уменьшения
     * damage_min|increase|percent, damage_min|decrease|absolutely, damage|max|equally, damage|min|equally, critical|decrease|absolutely, critical_damage|increase|percent, critical_chance|increase|absolutely
     * @param Collection $features
     * @param int $active
     * @param int $number_of_moves
     * @return array
     **/
    static function FeatureStatsUser(Collection $features, int $active, int $number_of_moves) : array{
        $features_list = [];

        foreach($features as $key => $f){

            $feature = [];

            $type = explode("|", $f->type);
            $stat = $type[0];//характериска: attack, shield, damage_min, damage_max, hp, mp, energy, critical_damage, critical_chance
            $operator = $type[1];//increase|decrease/max/min
            $method = $type[2];//percent|absolutely/equally
            $value = $f->value;

            //Если дейсвие количества ходов равно 0 и действие активное $active=1 или действие пассвиное $active= 0
            //То меняемся характеристики
            //Общие параметры для характеристик с одинаковым начальным условием
            if(($number_of_moves && $active) || !$active){
                if($stat == 'damage') {
                    $feature["damage_min"] = $value;
                    $feature["damage_max"] = $value;
                }
                elseif($stat == 'critical'){
                    $feature["critical_damage"] = $value;
                    $feature["critical_chance"] = $value;
                }else
                    $feature[$stat] = $value;

                $feature["operator"] = $operator;
                $feature["method"] = $method;

                if($f->image)
                    $feature["image"] = $f->image;

                $features_list[$key] = $feature;
            }
        }
        return $features_list;
    }

    /**
     * Функция возращает изменённое значение начальных параметров в зависимости от оператора и метода
     *
     * @var float $value
     * @param string $operator
     * @param string $method
     * @param float $user_stat
     * @return array
     */
    static function FeatureRatioValue(float $value, string $operator, string $method, float $user_stat) : array{
        $f_s = 0;
        $u_s = 0;

        if($operator == "increase" && $method == "percent") {
            $f_s = $user_stat*$value;
            $u_s = $user_stat*(1 + $value);
        }
        if($operator == "increase" && $method == "absolute") {
            $f_s = $value;
            $u_s = $user_stat + $value;
        }
        if($operator == "decrease" && $method == "percent") {
            $f_s = $user_stat*$value;
            $u_s = $user_stat*(1 - $value);
        }
        if($operator == "decrease" && $method == "absolute") {
            $f_s = (-1)*$value;
            $u_s = $user_stat + $value;
        }

        return ['f_s' => $f_s, 'u_s' => $u_s];
    }


    /**
     * Функция возращает защиту в зависимости от действия юнита
     *  @var int $user_id
     * @return object
     **/
    static function ActionDefence(int $user_id) : object{

    }

    /**
     * Функция пропускает действие и сохраняет все характеристики в зависимости от действия юнита
     *  @var int $user_id
     * @return object
     **/
    static function ActionWait(int $user_id) : object{

    }

    /**
    * Функция возращает урон от навыка в зависимости от действия юнита
     *  @var int $user_id
     *  @var int $skill_id
     * @return object
    **/
    static function ActionSkill(int $user_id, int $skill_id): object{

    }

    /**
     * Функция возращает урон от магии в зависимости от действия юнита
     *  @var int $user_id
     *  @var int $spell_id
     * @return object
     **/
    static function ActionSpell(int $user_id, int $spell_id): object{

    }

    /**
     * Функция возращает урон в зависимости от действия юнита: защиты, навыка, магии-бафа монстра и атаки, урона, навыка, магии-бафа героя
     *  @var int $user_id
     * @return object
     **/
    static function BattleActionAttack(){

    }

    /**
     * Функция генерирует объект дейсвия взависимости от action(обычная атака, защита, ждать, применить умение, применить магию)
     * Вспомогательная функция для Battle, генерации параметров
     *  @var int $user_id
     *  @var int $monster_id
     *  @var int $battle_id
     *  @var object $action
     * @return object
     **/
    static function Actions(int $user_id, int $monster_id, int $battle_id, object $action) : object{

        $user_property =  UserProperty::where('user_id', $user_id)->first();
        $monster_property = MonsterProperty::where('battle_id', $battle_id)->where('monster_id', $monster_id)->first();
        $user_skills =  UserI::getUserSkills($user_id);
        $monster_skills =  Monster::find($monster_id)->features()->get();
        //$monster_spells =  Monster::find($monster_id)->spells()->get();

        switch($action->id){
            case 1:
                return self::ActionAttack($user_property, $monster_property, $user_skills, $monster_skills);
            case 2:
                return self::ActionDefence($user_id);
            case 3:
                return self::ActionWait($user_id);
            case 4:
                return self::ActionSkill($user_id, $action->skill_id);
            case 5:
                return self::ActionSpell($user_id, $action->spell_id);
        }
    }

}