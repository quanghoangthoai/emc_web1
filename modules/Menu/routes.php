<?php

Route::group(['namespace' => 'Modules\Menu\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Menu
     */
    Route::group(['module' => 'Menu', 'middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/menus'], function () {

        Route::get('/', 'AdminController@getList')->name('mod_menu.admin.list_menu');

        Route::get('/add', 'AdminController@getAddMenu')->name('mod_menu.admin.add_menu');
        Route::post('/add', 'AdminController@postAddMenu')->name('mod_menu.admin.post_add_menu');

        Route::get('/edit/{id}', 'AdminController@getEditMenu')->name('mod_menu.admin.edit_menu');
        Route::post('/edit/{id}', 'AdminController@postEditMenu')->name('mod_menu.admin.post_edit_menu');

        Route::get('/delete/{id}', 'AdminController@getDeleteMenu')->name('mod_menu.admin.delete_menu');

        Route::get('/{id}', 'AdminController@getListItem')->name('mod_menu.admin.list_menu_item');
        Route::group(['prefix' => 'items'], function () {
            Route::get('/add/{id}', 'AdminController@getAddItem')->name('mod_menu.admin.add_menu_item');
            Route::post('/add/{id}', 'AdminController@postAddItem')->name('mod_menu.admin.post_add_item');

            Route::get('/edit/{id}', 'AdminController@getEditItem')->name('mod_menu.admin.edit_item');
            Route::post('/edit/{id}', 'AdminController@postEditItem')->name('mod_menu.admin.post_edit_item');

            Route::get('/delete/{id}', 'AdminController@getDeleteItem')->name('mod_menu.admin.delete_item');

            Route::post('/ajaxChangeOrderMenuItem', 'AdminController@ajaxChangeOderMenuItem')->name('mod_menu.admin.ajaxChangeOrderMenuItem');
            Route::post('/changeStatus', 'AdminController@ajaxChangeStatus')->name('mod_menu.ajax.changeStatus');
            Route::post('/loadlistitem', 'AdminController@ajaxLoadListItem')->name('mod_menu.admin.ajaxloadlistitem');
        });
    });
});