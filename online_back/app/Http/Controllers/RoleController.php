<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $role;
    protected $permission;
    protected $user;

    /**
     * RoleController constructor.
     *
     * @param $role
     * @param $permission
     * @param $user
     */
    public function __construct(RoleRepository $role,PermissionRepository $permission,UserRepository $user ) {
        $this->role       = $role;
        $this->permission = $permission;
        $this->user       = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = $this->role->getAll();
        return view('admin.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $top_permissions = $this->permission->getTopPermission();
        return view('admin.role.create',compact('top_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        //
        $flag = $this->role->store($request);
        if ($flag){
            return response()->json(['status'=>'201','msg'=>'角色创建成功']);
        }
        return response()->json(['status'=>'0','msg'=>'角色创建失败']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //展示单一角色,预加载用户和权限
        $role = $this->role->getById($id);
        return view('admin.role.list',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = $this->role->getById($id);
        //取出角色拥有权限的id数组
        $permissions = array_column($role->permission->toArray(),'id');
        //取出顶级权限
        $top_permissions = $this->permission->getTopPermission();

        return view('admin.role.edit',compact('role','top_permissions','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleStoreRequest $request, $id)
    {
        //
        $this->role->update($request,$id);
        return response()->json(['status'=>'200','msg'=>'角色更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //destory返回删除的记录数

        if ($count = $this->role->destroy($id)){
            return response()->json(['status'=>'200','msg'=>'角色删除成功']);
        }

        return response()->json(['status'=>'0','msg'=>'角色删除失败']);
    }
}
