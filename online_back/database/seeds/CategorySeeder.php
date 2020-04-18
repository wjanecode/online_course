<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //清空
        Category::truncate();

        Category::create([
            'name' => 'PHP进阶',
    ]);
        Category::create([
            'name' => 'linux',
        ]);
        Category::create([
            'name' => '数据结构',
        ]);
        Category::create([
            'name' => '算法基础'
        ]);
    }
}
