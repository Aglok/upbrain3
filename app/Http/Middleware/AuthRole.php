<?php

namespace App\Http\Middleware;

use Closure;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
            /* Проверка работы middleware для распределния прав доступа*/
//            if(\Auth::user()){
//                if(\Auth::user()->isManager() || \Auth::user()->isSuperAdmin()){
//                    return redirect()->guest('/admin');
//                }
//            }else{
//                return redirect()->guest('/');
//            }
            return $next($request);
    }
}
