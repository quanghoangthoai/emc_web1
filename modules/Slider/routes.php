<?php

Route::group(['module' => 'Slider', 'namespace' => 'Modules\Slider\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Slide
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/slides'], function () {
        Route::get('/', 'AdminController@getList')->name('mod_slide.admin.list_slide');
        Route::get('/add', 'AdminController@getAddSlide')->name('mod_slide.admin.add_slide');
        Route::post('/add', 'AdminController@postAddSlide')->name('mod_slide.admin.post_add_slide');
        Route::get('/edit/{id}', 'AdminController@getEditSlide')->name('mod_slide.admin.edit_slide');
        Route::post('/edit/{id}', 'AdminController@postEditSlide')->name('mod_slide.admin.post_edit_slide');
        Route::get('/delete/{id}', 'AdminController@getDeleteSlide')->name('mod_slide.admin.delete_slide');
        Route::post('/changeStatus', 'AdminController@ajaxChangeStatus')->name('mod_slide.ajax.changeStatus');
        Route::post('/ajaxChangeOrderSlide', 'AdminController@ajaxChangeOrderSlide')->name('mod_slide.admin.ajaxChangeOrderSlide');

        Route::group(['prefix' => 'blocks'], function () {
            Route::get('/', 'AdminController@getListBlock')->name('mod_block.admin.list_block');
            Route::get('/add', 'AdminController@getAddBlock')->name('mod_block.admin.add_block');
            Route::post('/add', 'AdminController@postAddBlock')->name('mod_block.admin.post_add_block');
            Route::get('/edit/{id}', 'AdminController@getEditBlock')->name('mod_block.admin.edit_block');
            Route::post('/edit/{id}', 'AdminController@postEditBlock')->name('mod_block.admin.post_edit_block');
            Route::get('/delete/{id}', 'AdminController@getDeleteBlock')->name('mod_block.admin.delete_block');
            Route::post('/ajaxChangeStatusBlock', 'AdminController@ajaxChangeStatusBlock')->name('mod_block.ajax.changeStatusBlock');
        });
    });
});