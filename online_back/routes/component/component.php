<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */
Route::group(['prefix'=>'component','namespace'=>'Component'],function(){
    //1,上传组件的路由
    //文件上传处理
    Route::post('uploader','UploaderController@uploader');
    //文件上传列表
    Route::post('filelists/[id]','UploaderController@filerlists');
});
