<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Repositories;


use App\Http\Requests\PermissionStoreRequest;
use App\Permission;
use App\Role;

class PermissionRepository {


    /**
     * 返回全部权限
     * @return Permission[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(  ) {
        return $permissions = Permission::all();
    }

    /**
     * 创建权限
     * @param PermissionStoreRequest $request
     *
     * @return mixed
     */
    public function store( PermissionStoreRequest $request ) {
        //保存权限
        return $permission = Permission::create([
            'name'      =>  trim($request->get('name')),
            'pid'       =>  $request->get('pid'),
            'routename' =>  trim($request->get('routename')),
        ]);

    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getById(int $id) {
        //dd(Permission::with('son')->find($id));
        return Permission::with('parent')->find($id);
    }

    /**
     * @param PermissionStoreRequest $request
     * @param int $id
     *
     * @return mixed
     */
    public function update(PermissionStoreRequest $request,int $id) {

        $permission = $this->getById($id);
        $permission->name = trim($request->get('name'));
        $permission->routename = trim($request->get('routename'));
        $permission->pid = $request->get('pid');
        $permission->save();
        return $permission;
    }

    public function destroy( int $id ) {
        //delete()方法是实例方法，需要查询到相应的数据并通过模型实例调用
        //
        //destroy()方法可以直接调用，通过索引删除记录
        //delete方法返回的是boolean值，true或false，destroy方法返回的是被删除的记录数。
        return $count = Permission::destroy($id);
    }

    public function getTopPermission(  ) {
        //获取顶级权限,预加载下级菜单
        return Permission::with('son')->where('pid','=',0)->get();
    }
}
