
<?php

Route::group(['middleware'=>'admin'],function (){
    //后台首页
    Route::get('/home', 'HomeController@index')->name('home');
//课程
    Route::resource('course','CourseController');
//分类标签
    Route::resource('cate','CategoryController');
//权限
    Route::resource('permission','PermissionController');
//用户
    Route::resource('user','UserController');
//ajax用户列表
    Route::post('/user/list','UserController@list')->name('user.list');
//用户分配角色
    Route::post('/user/role/{id}','UserController@roleSave')->name('user.role.save');
//用户分配角色展示页
    Route::get('user/role/{id}','UserController@roleShow')->name('user.role.show');
//角色
    route::resource('role','RoleController');
});

