<?php

Route::group(['module' => 'Request', 'namespace' => 'Modules\Request\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Request
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/requests'], function () {
        Route::get('/', 'AdminController@getListRequest')->name('mod_request.admin.list_request');
        Route::get('/add', 'AdminController@getAddRequest')->name('mod_request.admin.add_request');
        Route::post('/add', 'AdminController@postAddRequest')->name('mod_request.admin.post_add_request');
        Route::get('/detail/{id}', 'AdminController@getDetailRequest')->name('mod_request.admin.detail_request');
        Route::get('/edit/{id}', 'AdminController@getEditRequest')->name('mod_request.admin.edit_request');
        Route::post('/edit/{id}', 'AdminController@postEditRequest')->name('mod_request.admin.post_edit_request');
        Route::get('/delete/{id}', 'AdminController@deleteRequest')->name('mod_request.admin.delete_request');

        Route::post('/changeRequest', 'AdminController@ajaxChangRequest')->name('mod_request.ajax.changRequest');

        Route::post('/fetchItem', 'AdminController@ajaxFetchItem')->name('mod_request.ajax.fetchItem');
        Route::post('/fetchCart', 'AdminController@ajaxFetchCart')->name('mod_request.ajax.fetchCart');
        Route::post('/fetchBill', 'AdminController@ajaxFetchBill')->name('mod_request.ajax.fetchBill');
        Route::post('/fetchAction', 'AdminController@ajaxFetchAction')->name('mod_request.ajax.fetchAction');
        Route::post('/fetchImageAppend', 'AdminController@ajaxFetchImageAppend')->name('mod_request.ajax.fetchImageAppend');

        Route::post('/ajaxUploadImage', 'AdminController@ajaxUploadImage')->name('mod_request.ajax.uploadImage');
        Route::get('/getDownload/{id}', 'AdminController@getDownload')->name('mod_request.admin.getDownload');
        Route::post('/ajaxDeleteImage', 'AdminController@ajaxDeleteImage')->name('mod_request.ajax.deleteImage');
        Route::Post('/ajaxModalInsertRequest', 'AdminController@ajaxModalInsertRequest')->name('mod_request.ajax.modalInsertRequest');
        Route::post('/ajaxSearchCustomer', 'AdminController@ajaxSearchCustomer')->name('mod_request.ajax.searchCustomer');
    });
});
