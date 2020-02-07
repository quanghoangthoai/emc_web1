<?php

Route::group(['module' => 'Page', 'namespace' => 'Modules\Page\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Page
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/pages'], function () {
        Route::get('/', 'AdminController@getListPage')->name('mod_page.admin.list_page');

        Route::get('/add', 'AdminController@getAddPage')->name('mod_page.admin.add_page');
        Route::post('/add', 'AdminController@postAddPage')->name('mod_page.admin.post_add_page');

        Route::get('/edit/{id}', 'AdminController@getEdit')->name('mod_page.admin.edit_page');
        Route::post('/edit/{id}', 'AdminController@postEditPage')->name('mod_page.admin.post_edit_page');

        Route::get('/delete/{id}', 'AdminController@getDeletePage')->name('mod_page.admin.delete_page');
        Route::post('/changepage', 'AdminController@ajaxChangPage')->name('mod_page.admin.ajaxchangepage');
        Route::post('/changeStatus', 'AdminController@ajaxChangeStatus')->name('mod_page.ajax.changeStatus');
    });
});