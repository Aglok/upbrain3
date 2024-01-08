<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GameDuel
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $game_number
 * @property int|null $task_id
 * @property int|null $rating
 * @property int|null $time
 * @property int|null $solved
 * @property \Carbon\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereGameNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereSolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GameDuel whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|GameDuel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameDuel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameDuel query()
 */
class GameDuel extends Model
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
        $game_number = GameDuel::getAttributeValue('game_number');
        if($game_number){
            $game_number++;
        }else{
            $game_number = 1;
        }
        return $game_number;
    }
}
