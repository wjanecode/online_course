<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use Closure;

class CheckLogin
{
    /**
     * 只允许已登录的用户访问后台,并根据用户权限展示可以看到的内容
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取当前路由名
        $currentRouteName = $request->route()->getName();
        //dd($currentRouteName);

        //判断用户是否登录,
        //未验证 或者 当前路由为login,重定向login
        if (!auth()->check() || $currentRouteName == 'login'){
            // 清空session
            session()->flush();
            // 跳转登录页面
            return redirect(route('login'))->withErrors(['errors' => '请登录']);
        }

        //----------------已登录,权限判断
        //获取用户权限
        $permissions = array_column(auth()->user()->role->permission->toArray(),'routename');
        //权限有多级,取出下级,多个权限是以,分隔的路由
        $permissionArr = [];
        foreach ($permissions as $permission){
            if(strrchr($permission,',')){
                //字符串分隔成数组,合并
                $permissionArr = array_merge($permissionArr,explode(',',$permission));
            }else{
                //添加字符串到数组
                array_push($permissionArr,$permission);
            }
        }

        //添加不需要验证的权限
        $permissionArr = array_merge($permissionArr,config('permission'));
        //dd($permissionArr);

        //访问没有的权限,抛出异常,对超管不验证
        //不是超管,也不在权限数组内,同时成立,抛出异常
        if (auth()->user()->name !== 'admin' && !in_array($currentRouteName,$permissionArr)){
            throw new AuthException('你无权访问');
        }


        return $next($request);
    }
}
