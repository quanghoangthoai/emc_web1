<?php

/**
 * Route Banner Module
 */

// Register namespace
$namespace = 'Modules\Banner\Controllers';

Route::group(['module' => 'Banner', 'namespace' => $namespace], function () {

    // Admin
    Route::group(['prefix' => config('cms.admin_prefix') . '/banners', 'middleware' => 'admin'], function () {

        Route::get('/', 'AdminController@getListAllBanner')->name('mod_banner.admin.listallbanner');
        Route::get('/detail/{id}', 'AdminController@getDetailBanner')->name('mod_banner.admin.detailbanner');
        Route::get('/add', 'AdminController@getAddBanner')->name('mod_banner.admin.addbanner');
        Route::post('/add', 'AdminController@postAddBanner')->name('mod_banner.admin.postaddbanner');
        Route::get('/edit/{id}', 'AdminController@getEditBanner')->name('mod_banner.admin.editbanner');
        Route::post('/edit/{id}', 'AdminController@postEditBanner')->name('mod_banner.admin.posteditbanner');
        Route::get('/delete/{id}', 'AdminController@getDeleteBanner')->name('mod_banner.admin.deletebanner');

        // ajax
        Route::post('/changebanner', 'AdminController@ajaxChangeBanner')->name('mod_banner.admin.ajaxchangebanner');

        // Block
        Route::group(['prefix' => 'blocks'], function () {
            Route::get('/', 'AdminController@getListBlock')->name('mod_banner.admin.listblock');
            Route::get('/add', 'AdminController@getAddBlock')->name('mod_banner.admin.addblock');
            Route::post('/add', 'AdminController@postAddBlock')->name('mod_banner.admin.postaddblock');
            Route::get('/edit/{id}', 'AdminController@getEditBlock')->name('mod_banner.admin.editblock');
            Route::post('/edit/{id}', 'AdminController@postEditBlock')->name('mod_banner.admin.posteditblock');
            Route::get('/delete/{id}', 'AdminController@getDeleteBlock')->name('mod_banner.admin.deleteblock');
        });
    });

    // Public
    // Route::get('/banner/click/{id}', 'BannerController@getClickBanner')->name('mod_banner.clickbanner');
});