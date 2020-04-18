<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * 当用户已登录，但访问被限制的路径时，会被重定向至指定路径。
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        //守卫的配置在config.auth下
        if (Auth::guard($guard)->check()) {
            session()->flash('msg', '您已登录，无需再次操作。');
            return redirect('/home');
        }

        return $next($request);
    }
}
