<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //如果是超级管理员,就显示所有权限
        if (auth()->user()->name == 'admin'){
            $permissions = Permission::all();
        }else{
            //不是就获取用户权限
            $permissions = auth()->user()->role->permission;
        }
        return view('admin.index.index',compact('permissions'));
    }
}
