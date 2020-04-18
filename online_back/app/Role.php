<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Permission;

class Role extends Model
{
    //软删除,使用trait
    use SoftDeletes;
    protected $guarded =[];

    /**
     * 关联权限表 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permission(  ) {
        return $this->belongsToMany(Permission::class,'role_permission','rid','pid');
    }

    /**
     * 角色用户关联,一对多 以后做成多对多
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(  ) {
        return $this->hasMany(User::class,'role_id');
    }

}
