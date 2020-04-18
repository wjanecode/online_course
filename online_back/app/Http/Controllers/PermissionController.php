<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permission;
    protected $role;

    /**
     * PermissionController constructor.
     *
     * @param $permission
     * @param $role
     */
    public function __construct(PermissionRepository $permission, RoleRepository $role ) {
        $this->permission = $permission;
        $this->role       = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取权限,并返回视图
        $permissions = $this->permission->getAll();
        return view('admin.permission.index',compact('permissions'));

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
        return view('admin.permission.create',compact('top_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        //
        $permission = $this->permission->store($request);
        if ($permission->id){
            return response()->json(['status'=>'201','msg'=>'权限创建成功']);
        }
        return response()->json(['status'=>'0','msg'=>'权限创建失败']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

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
        //
        $permission = $this->permission->getById($id);
        $top_permissions = $this->permission->getTopPermission();

        return view('admin.permission.edit',compact('permission','top_permissions'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionStoreRequest $request, $id)
    {
        //
        $permission = $this->permission->update($request,$id);
        //这里的判断方法不对,先查清save()的返回值
        if($permission){
            return response()->json(['status'=>'201','msg'=>'权限更新成功']);
        }
        return response()->json(['status'=>'0','msg'=>'权限更新失败']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //destory返回删除的记录数

        if ($count = $this->permission->destroy($id)){
            return response()->json(['status'=>'200','msg'=>'权限删除成功']);
        }

        return response()->json(['status'=>'0','msg'=>'权限删除失败']);
    }
}
