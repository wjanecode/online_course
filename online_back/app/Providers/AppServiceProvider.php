<?php

namespace App\Providers;

use App\Observers\PermissionObserver;
use App\Permission;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //本地数据库版本问题,string最大长度只有191,laravel默认的会超限
        Schema::defaultStringLength(191);
        //权限观察者
        Permission::observe(PermissionObserver::class);
    }
}
