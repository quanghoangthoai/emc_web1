<?php

Route::group(['module' => 'Order', 'namespace' => 'Modules\Order\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Order
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/orders'], function () {
        Route::get('/', 'AdminController@getList')->name('mod_order.admin.list');
        Route::get('/detail-order/{id}', 'AdminController@getOrder')->name('mod_order.admin.order');
        Route::get('/cancel-order/{id}', 'AdminController@getCancelOrder')->name('mod_order.admin.cancel_order');
        Route::get('/process-order/{id}', 'AdminController@getProcessOrder')->name('mod_order.admin.process_order');
        Route::get('/finish-order/{id}', 'AdminController@getFinishOrder')->name('mod_order.admin.finish_order');
        Route::get('/open-order/{id}', 'AdminController@getOpenOrder')->name('mod_order.admin.open_order');
        Route::get('chart', 'Widgetcontroller@index')->name('mod_order.widget.revenue');
    });

    Route::group(['middleware' => ['web', 'auth'], 'prefix' => '/clients'], function () {
        //Client Orders
        Route::get('/orders', 'ClientController@getOrders')->name('client.orders');
        //Client DetailOrder
        Route::get('/detail-order/{order_id}', 'ClientController@getDetailOrder')->name('client.detail_order');
    });
});
