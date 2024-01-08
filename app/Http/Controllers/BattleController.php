<?php

namespace App\Http\Controllers;
use App\Models\Battle;
use App\Models\MonsterProperty;
use App\Models\UserProperty;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Models\Mission;
use App\Helpers\UserInterface as UserI;


class BattleController extends Controller
{
    public function battle(Request $request){

        if ($request->ajax()) {

            //Получаем данные о битве после загрузки страницы и процесс битвы обрабатывается через Post
                try {

                    $user_id = $request->get('user_id');
                    $mission_id = $request->get('mission_id');
                    $subject = $request->get('subject');
                    $answer = $request->get('answer');
                    $action_id = $request->get('action_id');
                    $current_time = $request->get('current_time');
                    $monster_id = Mission::whereId($mission_id)->value('monster_id');
                    $count_tasks = 0;
                    $battle_id = 0;//Заглушка от ошибок

                    # Параметр battle_id, либо передаётся, либо генерирутеся новый на сервере, новый battle_id, создаётся преподавателем связной с mission_id
                    # Переход к battle происход по нажатию на кнопку -> к заданию
                    if ($request->has('battle_id')){

                        $battle_id = $request->get('battle_id');
                        $battle = Battle::find($battle_id);
                        $count_tasks = $battle->count_tasks + 1;

                        $battle->update([
                            'user_id' => $user_id,
                            'monster_id' =>  $monster_id,
                            'count_tasks' => $count_tasks,
                            'current_time' => $current_time
                        ]);
                        //Тут будут обрабатываться параметры actions
                    }

                }catch (Exception $e) {
                    return view('errors.request', ['error' => $e->getMessage()]);
                }

            return response()->json([
                //'battle' => $battle,
                'user_property' => UserProperty::where('user_id', $user_id)->first(),
                'monster_property' => MonsterProperty::where('battle_id', $battle_id)
                    ->where('monster_id', $monster_id)->first(),
                'skills' => UserI::getUserSkills($user_id),
                'action' => '',
                'task' => UserI::getMissionTasks($mission_id, $subject)[$count_tasks]
            ]);

        }
    }
}