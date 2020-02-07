<?php

Route::group(['middleware' => 'web'], function () {

    // Mod: Contact
    Route::group(['module' => 'Contact', 'namespace' => 'Modules\Contact\Controllers'], function () {
        Route::get('lien-he', 'WebController@getSend')->name('mod_contact.web.send_contact');
        Route::post('lien-he', 'WebController@postSend')->name('mod_contact.web.post_send_contact');
    });

    // Mod: User
    Route::group(['module' => 'User', 'namespace' => 'Modules\User\Controllers'], function () {
        Route::get('dang-nhap', 'WebController@getLogin')->name('login');
        Route::get('dang-xuat', 'WebController@getLogout')->name('logout');
        Route::post('dang-nhap', 'WebController@postLogin')->name('post_login');

        Route::get('dang-ky', 'WebController@getRegister')->name('register');
        Route::post('dang-ky', 'WebController@postRegister')->name('post_register');
    });

    // Mod: Post
    Route::group(['module' => 'Post', 'namespace' => 'Modules\Post\Controllers'], function () {
        Route::get('tin-tuc', 'WebController@getMainPost')->name('mod_post.web.main_post');
        Route::get('tin-tuc/{slug}', 'WebController@getDetailPost')->name('mod_post.web.detail_post');
    });

    // Mod: Recruitment
    Route::group(['module' => 'Recruitment', 'namespace' => 'Modules\Recruitment\Controllers'], function () {
        Route::get('tuyen-dung', 'WebController@getListJob')->name('mod_recruitment.web.list_job');
        Route::get('tuyen-dung/{slug}', 'WebController@getDetailPost')->name('mod_recruitment.web.detail_job');
        Route::post('ajaxApplyJob', 'WebController@ajaxApplyJob')->name('mod_recruitment.ajax.apply_job');
    });

    // Mod: Request
    Route::group(['module' => 'Request', 'namespace' => 'Modules\Request\Controllers'], function () {
        Route::get('gio-hang', 'WebController@getCart')->name('mod_request.web.view-cart');
    });

    // Mod: Web
    Route::group(['module' => 'Web', 'namespace' => 'Modules\Web\Controllers'], function () {
        // VNPAY
        Route::group(['prefix' => 'vnpay'], function () {
            Route::get('payment', 'VnPayController@getPayment')->name('vnpay.payment');
            Route::get('IPN', 'VnPayController@getIPN')->name('vnpay.ipn');
            Route::get('resultPayment', 'VnPayController@getResultPayment')->name('vnpay.result_payment');
        });

        Route::get('/', 'HomeController@getHome')->name('home');
        Route::get('/{slug}', 'WebController@executeSlug')->name('executeSlug')->where('slug', '^((?!' . config('cms.admin_prefix') . ')(?!clients)(?!login)(?!auth)(?!id).)*$');
    });
});
