<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App
 */
class Permission extends Model
{
    //不可填充字段为空
    protected $guarded = [];

    /**
     * 表只设两级菜单,子菜单跟父菜单为多对一,找爸爸
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 一多关系
     * 都是以多的那张表来联查,即foreignKey在多的那张表上
     * 单表联查的当两张表就好
     */
    public function parent(  ) {
        return $this->belongsTo(Permission::class,'pid','id');
    }

    /**
     * 找儿子
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function son(  ) {
        return $this->hasMany(Permission::class,'pid','id');
    }

}
