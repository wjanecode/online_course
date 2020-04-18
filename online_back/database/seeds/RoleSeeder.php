<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //截断表,重置
        Role::truncate();
        //插入数据
        Role::insert([
            'name' => '默认'
        ]);

    }
}
