<?php

namespace App\Helpers;

use DB;

class UserInterface
{
    /**
     * Определяем свойство $lvl;
     * @return integer
     * Функция конвертирует опыт ученика в уровень по заданной таблице
     * */
    public static function convertExpInLvl($sum)
    {

        $lvl = 0;

        if ($sum >= 1000 && $sum < 2000) {
            $lvl = 1;
        } elseif ($sum >= 2000 && $sum < 3200) {
            $lvl = 2;
        } elseif ($sum >= 3200 && $sum < 4800) {
            $lvl = 3;
        } elseif ($sum >= 4800 && $sum < 7300) {
            $lvl = 4;
        } elseif ($sum >= 7300 && $sum < 12600) {
            $lvl = 5;
        }elseif ($sum >= 12600 && $sum < 20600) {
            $lvl = 6;
        }elseif ($sum >= 20600 && $sum < 25600) {
            $lvl = 7;
        }
        elseif ($sum >= 25600 && $sum < 34600) {
            $lvl = 8;
        }
        elseif ($sum >= 34600 && $sum < 48200) {
            $lvl = 9;
        }

        return $lvl;
    }

    public static function getSexUser($user_id)
    {

        $sex = DB::table('users')->where('id', $user_id)->value('sex');
        if ($sex == 'M') {
            $dir = 'man';
        } else {
            $dir = 'woman';
        }

        return $dir;
    }

    /**
     * @var $user_id
     * @return array
     * Функция собирает данные из таблицы images_of_characters и users_body
     * Выводит образы персонажей
     * */
    public static function getImageCharacter($user_id)
    {

        $dir = static::getSexUser($user_id);

        $image_char = DB::table('images_of_characters as ioc')
            ->leftJoin('users_body as ub', 'ioc.id', '=', 'ub.image_of_character_id')
            ->select('name', 'description', 'small_image_m', 'big_image_m', 'small_image_w', 'big_image_w', 'user_level')
            ->where('ub.user_id', '=', $user_id)
            ->get()->toArray();

        return [$image_char, $dir];
    }

    /**
     * @var $user_id
     * @return array
     * Функция собирает данные из таблицы trophy и users_trophy, rarity
     * Фильтрует массив от пустых значений и создает список характеристик трофеев
     * */
    public static function getArtifactPerson($user_id)
    {
        $arr = [];//Вспомогательный массив
        $artifacts = DB::table('artifacts as art')
            ->leftJoin('users_artifacts as uart', 'art.id', '=', 'uart.artifact_id')
            ->leftJoin('rarity', 'art.rarity_id', '=', 'rarity.id')
            ->leftJoin('artifacts_type as art_type', 'art.artifact_type_id', '=', 'art_type.id')
            ->select('art.name', 'art.description', 'art_type.dir as dir', 'image', 'attack', 'defense', 'magic', 'energy', 'increase_experience', 'increase_gold', 'rarity.name as rarity', 'weight', 'user_level')
            ->where('uart.user_id', '=', $user_id)
            ->get();

        foreach ($artifacts as $artifact => $specifications) {

            $info = '<ul class="list-unstyled">';
            $filteredArtifactSpecification = [];//Массива содержит отфильтрованные характеристики отличные от 0

            foreach ($specifications as $specification => $value) {
                if (!$value) continue;

                $info .= '<li>';
                if ($specification == 'name' || $specification == 'description') {
                    $info .= $value;
                } elseif ($specification == 'attack') {
                    $info .= 'атака: ' . $value;
                } elseif ($specification == 'damage_min') {
                    $info .= 'мин. урон: ' . $value;
                } elseif ($specification == 'damage_max') {
                    $info .= 'макс. урон: ' . $value;
                } elseif ($specification == 'defense') {
                    $info .= 'защита: ' . $value;
                } elseif ($specification == 'magic') {
                    $info .= 'магия: ' . $value;
                } elseif ($specification == 'energy') {
                    $info .= 'энергия: ' . $value;
                } elseif ($specification == 'increase_experience') {
                    $info .= 'увл. опыта: ' . ($value * 100) . '%';
                } elseif ($specification == 'increase_gold') {
                    $info .= 'увл. золота: ' . ($value * 100) . '%';
                } elseif ($specification == 'rarity') {
                    $info .= 'редкость: ' . $value;
                } elseif ($specification == 'weight') {
                    $info .= 'вес: ' . $value;
                } elseif ($specification == 'user_level') {
                    $info .= 'треб. уровень: ' . $value;
                }
                $info .= '</li>';
                $filteredArtifactSpecification[$specification] = $value;
            }
            $info .= '</ul>';
            $filteredArtifactSpecification['info'] = $info;
            array_push($arr, (object)$filteredArtifactSpecification);
        }

        return $arr;
    }

    public static function getArtifactPersonFilteredForExpGold($user_id)
    {

        $artifacts = static::getArtifactPerson($user_id);
        $arr = [];//Вспомогательный массив

        foreach ($artifacts as $artifact => $specifications) {

            //Массива содержит отфильтрованные характеристики отличные от 0 по experience и gold
            $filteredExpGoldArtifactSpec = [];

            foreach ($specifications as $specification => $value) {
                if ($specification == 'increase_experience' || $specification == 'increase_gold') {
                    if ($value) $filteredExpGoldArtifactSpec[$specification] = $value;
                }

            }

            array_push($arr, $filteredExpGoldArtifactSpec);
        }

        return $arr;
    }

    public static function getUserClass($user_id)
    {

        return DB::table('users_class as uc')
            ->leftJoin('classes_person as cp', 'cp.id', '=', 'uc.class_person_id')
            ->select('name', 'description', 'attack', 'defense', 'magic', 'energy', 'health_point', 'increase_experience', 'increase_gold', 'skill_1_id', 'skill_2_id', 'skill_3_id', 'icon_man', 'icon_woman')
            ->where('uc.user_id', $user_id)
            ->get();
    }

    public static function getUserProgress($user_id){
        return DB::table('users_progress as u_prg')
            ->leftJoin('progress as prg', 'prg.id', '=', 'u_prg.progress_id')
            ->select('name', 'description', 'type', 'rank', 'quality', 'list_grade', 'image')
            ->where('u_prg.user_id', $user_id)
            ->get();
    }
}