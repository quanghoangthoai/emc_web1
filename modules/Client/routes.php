<?php

Route::group(['middleware' => ['web', 'auth'], 'module' => 'Client', 'namespace' => 'Modules\Client\Controllers', 'prefix' => 'clients'], function () {
    // Index Client
    Route::get('/', 'HomeController@getIndex')->name('client.index');

    // Client my products
    Route::get('/my-products', 'ClientController@getMyProduct')->name('client.my_products');
    // Client products
    Route::get('/products', 'ClientController@getProduct')->name('client.products');
    //Client Requests
    Route::get('/requests', 'ClientController@getRequests')->name('client.requests');


    //Client getProfiles
    Route::get('/profiles', 'ClientController@getProfiles')->name('client.profiles');
    //Client getChangePassword
    Route::get('/change-password', 'ClientController@getChangePassword')->name('client.change_password');
    //Client Recruitment
    Route::get('/recruitments', 'ClientController@getRecruitments')->name('client.recruitments');
    //Client HistoryDownload
    Route::get('/history-download', 'ClientController@getHistoryDownload')->name('client.history_download');
    //Client DetailHistoryDownload
    Route::get('/detail-history-download', 'ClientController@getDetailHistoryDownload')->name('client.detail_history_download');
    //Client account
    Route::get('/my-account', 'ClientController@getMyAccount')->name('client.my_account');

    Route::get('/unlink-social/{provider}', 'ClientController@getUnlinkSocial')->name('client.unlink_social');
});
