<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('role_id')->default(1)->comment('角色id');
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->comment('头像');
            $table->timestamp('email_verified_at')->nullable()->comment('邮箱验证字段');
            $table->string('password');
            $table->string('api_token',60)->unique()->comment('apitoken验证');//api_token验证
            $table->string('status','2')->default('T')->comment('标记用户状态');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
