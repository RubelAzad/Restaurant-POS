<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $role_id = auth()->user()->role_id;
            $login_token = auth()->user()->login_token;
            $APP_REACT_POS_URL= env('APP_REACT_POS_URL');
            if($role_id == 4){
                if($login_token === 'NULL'){
                    Auth::logout();
                }else{
                    
                    return redirect()->away($APP_REACT_POS_URL.'insignia-pos?token='.$login_token);
                }
                
            }else{
                return redirect(RouteServiceProvider::HOME);
            }
            
        }

        return $next($request);
    }
}
