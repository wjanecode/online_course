<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Repositories;

use App\Http\Requests\RoleStoreRequest;
use App\Role;

class RoleRepository {

    public function getAll(  ) {
        return Role::with('user','permission')->get();
    }

    public function store(RoleStoreRequest $request  ) {
        $data = [
            'name'          =>  trim($request->get('name')),
            'description'   =>  trim($request->get('description')),
        ];
        //创建角色
        $role = Role::create($data);

        //添加到role_permission权限表
        //先获取权限的id数组
        $permissions = $request->get('permissions');

        //attach()附加到表
        $role->permission()->attach($permissions);

        //没有抛出异常返回
        return true;

    }

    public function getById(int $id  ) {
        return Role::with('permission')->find($id);
    }

    public function update(RoleStoreRequest $request,int $id  ) {
        $role = Role::find($id);
        $role->name         =   trim($request->get('name'));
        $role->description  =   trim($request->get('description'));
        $role->save();//save方法会更新时间戳

        //更新权限关联表
        $role->permission()->sync($request->get('permissions'));
    }

    public function destroy(int $id  ) {
        return Role::destroy($id);//destory()会返回删除的记录数,delete()要调用实例,返回Boolean值
    }

}
