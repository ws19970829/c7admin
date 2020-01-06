<?php
Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //后台登录
    Route::get('login','LoginController@index')->name('login');
    Route::post('login','LoginController@dologin')->name('login');

    //后台
    Route::group(['middleware'=>['checkadmin']],function(){

        //后台首页
        Route::get('index','IndexController@index')->name('index');
        //后台欢迎页
        Route::get('welcome','IndexController@welcome')->name('welcome');
        //退出
        Route::get('logout','IndexController@logout')->name('logout');

        //用户
        Route::delete('admin/delall','AdminController@delall')->name('admin.delall');
        Route::resource('admin','AdminController');

        //角色
        Route::delete('role/delall','RoleController@delall')->name('role.delall');
        Route::resource('role','RoleController');

        //权限
        Route::delete('node/delall','NodeController@delall')->name('node.delall');
        Route::resource('node','NodeController');

        //平台
        //实时数据
        Route::get('grade/user/{id}','GradeController@user')->name('grade.user');
        Route::resource('spend','SpendController');
        //等级统计

        Route::resource('grade','GradeController');
        //下载统计
        Route::get('download/gamedownload','DownloadController@gameDown')->name('download.gamedownload');
        Route::resource('download','DownloadController');


        //玩家=>用户
        Route::resource('user','UserController');




    });

});
