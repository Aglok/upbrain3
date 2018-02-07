<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class GameDuelController extends Controller
{

    public function index(){
        return view('game.duel');
    }

}
