<?php

Route::group(['module' => 'Contact', 'namespace' => 'Modules\Contact\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Contact
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/contacts'], function () {
        // get list contact
        Route::get('/', 'AdminController@getListContacts')->name('mod_contact.admin.list_contact');

        // get view contac
        Route::get('/view/{id}', 'AdminController@getViewContact')->name('mod_contact.admin.viewcontact');
        Route::post('/edit/{id}', 'AdminController@postEditContact')->name('mod_contact.admin.posteditcontact');

        // action Bulk
        Route::post('/bulkaction', 'AdminController@postBulkAction')->name('mod_contact.admin.bulkaction');
        // Config
        Route::get('config', 'AdminController@getConfig')->name('mod_contact.admin.config');
        Route::post('config', 'AdminController@postConfig')->name('mod_contact.admin.postconfig');

        // get send mail

        Route::get('send', 'ContactController@getSend')->name('mod_contact.public.sendcontact');
        Route::post('send', 'ContactController@posSend')->name('mod_contact.public.postsendcontact');
    });
});