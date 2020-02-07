<?php

Route::group(['module' => 'Post', 'namespace' => 'Modules\Post\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Post
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/posts'], function () {
        Route::get('/', 'AdminController@getListPost')->name('mod_post.admin.list_post');
        Route::get('/add', 'AdminController@getAddPost')->name('mod_post.admin.add_post');
        Route::post('/add', 'AdminController@postAddPost')->name('mod_post.admin.post_add_post');
        Route::get('/edit/{id}', 'AdminController@getEditPost')->name('mod_post.admin.edit_post');
        Route::post('/edit/{id}', 'AdminController@postEditPost')->name('mod_post.admin.post_edit_post');
        Route::get('/delete/{id}', 'AdminController@getDeletePost')->name('mod_post.admin.delete_post');

        Route::post('/ajaxChangeStatusPost', 'AdminController@ajaxChangeStatusPost')->name('mod_post.ajax.changeStatusPost');

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'AdminController@getListCategory')->name('mod_post.admin.list_category');
            Route::get('/add', 'AdminController@getAddCategory')->name('mod_post.admin.add_category');
            Route::post('/add', 'AdminController@postAddCategory')->name('mod_post.admin.post_add_category');
            Route::get('/edit/{id}', 'AdminController@getEditCategory')->name('mod_post.admin.edit_category');
            Route::post('/edit/{id}', 'AdminController@postEditCategory')->name('mod_post.admin.post_edit_category');
            Route::get('/delete/{id}', 'AdminController@getDeleteCategory')->name('mod_post.admin.delete_category');
            Route::post('/ajaxChangeStatusCategory', 'AdminController@ajaxChangeStatusCategory')->name('mod_post.ajax.changeStatusCategory');
            Route::post('/ajaxChangeOrderCategory', 'AdminController@ajaxChangeOrderCategory')->name('mod_post.admin.ajaxChangeOrderCategory');
        });
    });
});