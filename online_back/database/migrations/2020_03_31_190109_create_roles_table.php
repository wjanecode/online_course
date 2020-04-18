<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建roles角色表
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->default('')->comment('角色名');
            $table->string('description','255')->nullable()->comment('描述');
            $table->timestamps();
            //软删除
            $table->softDeletes();
        });
        //创建角色权限关联表
        Schema::create('role_permission', function (Blueprint $table) {
            $table->unsignedInteger('rid')->default(0)->comment('角色id');
            $table->unsignedInteger('pid')->default(0)->comment('权限id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_permission');
    }
}
