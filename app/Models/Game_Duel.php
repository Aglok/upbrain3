<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game_Duel extends Model
{
    protected $table = 'games_duel';
    protected $fillable = [
        'user_id',
        'game_number',//уникальный номер игры
        'task_id', //номер попавшейся задачи
        'solved', //решена/нерешена задача 1/0
        'rating'//уровень сложности задач
    ];

    /**
     * Функция генерирует уникальный номер игры
     */
    public static function genIdUniqueGames(){
        $game_number = Game_Duel::getAttributeValue('game_number');
        if($game_number){
            $game_number++;
        }else{
            $game_number = 1;
        }
        return $game_number;
    }
}
