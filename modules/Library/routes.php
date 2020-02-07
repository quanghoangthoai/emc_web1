<?php

Route::group(['module' => 'Library', 'namespace' => 'Modules\Library\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Library
     */
    // Route For Document
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/libraries'], function () {
        Route::get('/', 'AdminController@getListDocument')->name('mod_library.admin.get_list_document');
        Route::get('/add', 'AdminController@getAddDocument')->name('mod_library.admin.get_add_document');
        Route::post('/add', 'AdminController@postAddDocument')->name('mod_library.admin.post_add_document');
        Route::get('edit/{id}', 'AdminController@getEditDocument')->name('mod_library.admin.get_edit_document');
        Route::post('edit/{id}', 'AdminController@postEditDocument')->name('mod_library.admin.post_edit_document');
        Route::get('detail/{id}', 'AdminController@getDetailDocument')->name('mod_library.admin.get_detail_document');
        Route::get('download/{id}', 'AdminController@getDownload')->name('mod_library.admin.get_download');
        Route::get('delete/{id}', 'AdminController@getDeleteDocument')->name('mod_library.admin.get_delete_document');
        Route::post('fetchExtend', 'AdminController@ajaxFetchExtend')->name('mod_library.ajax.fetchExtend');
    });
    // Route for Category
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/libraries/categories'], function () {
        Route::get('/', 'AdminController@getListCategory')->name('mod_library.admin.get_list_category');
        Route::get('/add', 'AdminController@getAddCategory')->name('mod_library.admin.get_add_category');
        Route::post('/add', 'AdminController@postAddCategory')->name('mod_library.admin.post_add_category');
        Route::get('/edit/{id}', 'AdminController@getEditCategory')->name('mod_library.admin.get_edit_category');
        Route::post('/edit/{id}', 'AdminController@postEditCategory')->name('mod_library.admin.post_edit_category');
        Route::get('/delete/{id}', 'AdminController@getDeleteCategory')->name('mod_library.admin.get_delete_category');
    });

    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/libraries/histories'], function () {
        Route::get('/', 'AdminController@getListHistory')->name('mod_library.admin.get_list_history');
        Route::get('/delete/{id}', 'AdminController@getDeleteHistory')->name('mod_library.admin.get_delete_history');
        Route::get('/deletes', 'AdminController@getDeleteAllHistory')->name('mod_library.admin.get_delete_all_history');
    });
});
