<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class AuthController extends Controller
{
    private Guard $auth;


    /**
     * Create a new authentication controller instance.
     *
     * @param Guard $auth
     * @return void
     */
    
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest', ['except' => 'getLogout']);
    }
}
