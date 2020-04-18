<?php

use Illuminate\Database\Seeder;

use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用factory生成假数据,传入类名,返回
        $user = factory(User::class)->times(100)->make()->toArray();

        //清空数据表
        User::truncate();
        //插入数据
        User::insert($user);
    }
}
