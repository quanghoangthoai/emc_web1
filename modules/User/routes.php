<?php

Route::group(['namespace' => 'Modules\User\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: User
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/departments'], function () {
        Route::get('/', 'DepartmentController@getListDepartment')->name('mod_user.admin.list_department');
        Route::post('/add', 'DepartmentController@postAddDepartment')->name('mod_user.admin.post_add_department');
        Route::get('/edit/{id}', 'DepartmentController@getEditDepartment')->name('mod_user.admin.edit_department');
        Route::post('/edit/{id}', 'DepartmentController@postEditDepartment')->name('mod_user.admin.post_edit_department');
        Route::get('/delete/{id}', 'DepartmentController@getDeleteDepartment')->name('mod_user.admin.delete_department');
    });

    /**
     * ROUTES FOR ADMIN: User
     */
    Route::group(['module' => 'User', 'middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/users'], function () {
        Route::get('/', 'AdminController@getListUser')->name('mod_user.admin.list_user');
        Route::get('/add', 'AdminController@getAddUser')->name('mod_user.admin.add_user');
        Route::post('/add', 'AdminController@postAddUser')->name('mod_user.admin.post_add_user');
        Route::get('/edit/{id}', 'AdminController@getEditUser')->name('mod_user.admin.edit_user');
        Route::post('/edit/{id}', 'AdminController@postEditUser')->name('mod_user.admin.post_edit_user');
        Route::get('/delete/{id}', 'AdminController@getDeleteUser')->name('mod_user.admin.delete_user');

        Route::post('/changeStatus', 'AdminController@ajaxChangeStatus')->name('mod_user.ajax.changeStatus');
    });

    Route::get(config('cms.admin_prefix') . '/login', 'AuthController@getLoginAdmin')->middleware('web')->name('mod_user.admin.login');
    Route::get(config('cms.admin_prefix') . '/logout', 'AuthController@getLogoutAdmin')->middleware('web')->name('mod_user.admin.logout');
    Route::post(config('cms.admin_prefix') . '/login', 'AuthController@postLoginAdmin')->middleware('web')->name('mod_user.admin.post_login');

    Route::get('login/{provider}', 'AuthController@redirectToProvider')->middleware('web')->name('login.social');
    Route::get('auth/{provider}/callback', 'AuthController@handleProviderCallback')->middleware('web');
});