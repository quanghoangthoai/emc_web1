<?php

Route::group(['module' => 'Service', 'namespace' => 'Modules\Service\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Service
     */
    // Route for Service
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/services'], function () {
        Route::get('/', 'AdminController@getListService')->name('mod_service.admin.list_service');
        Route::get('/add', 'AdminController@getAddService')->name('mod_service.admin.add_service');
        Route::post('/add', 'AdminController@postAddService')->name('mod_service.admin.post_add_service');
        Route::get('/edit/{id}', 'AdminController@getEditService')->name('mod_service.admin.edit_service');
        Route::post('/edit/{id}', 'AdminController@postEditService')->name('mod_service.admin.post_edit_service');
        Route::get('/delete/{id}', 'AdminController@getDeleteService')->name('mod_service.admin.delete_service');
        Route::post('/changeStatusService', 'AdminController@changeStatusService')->name('mod_service.ajax.changeStatusService');
        Route::post('/ajaxChangeOrderService', 'AdminController@ajaxChangeOrderService')->name('mod_service.admin.ajaxChangeOrderService');
        Route::get('chart', 'WidgetController@index')->name('mod_service.widget.chart');

        // Route for Category
        Route::group(['prefix' => '/categories'], function () {
            Route::get('/', 'AdminController@getListCategory')->name('mod_service.admin.list_category');
            Route::post('/', 'AdminController@postAddCategory')->name('mod_service.admin.post_add_category');
            Route::get('/edit/{id}', 'AdminController@getEditCategory')->name('mod_service.admin.edit_category');
            Route::post('/edit/{id}', 'AdminController@postEditCategory')->name('mod_service.admin.post_edit_category');
            Route::get('/delete/{id}', 'AdminController@getDeleteCategory')->name('mod_service.admin.delete_category');
            Route::post('/changeStatusCategory', 'AdminController@changeStatusCategory')->name('mod_service.ajax.changeStatusCategory');
            Route::post('/ajaxChangeOrderCategory', 'AdminController@ajaxChangeOrderCategory')->name('mod_service.admin.ajaxChangeOrderCategory');
        });
    });
});
