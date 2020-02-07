<?php

Route::group(['module' => 'Product', 'namespace' => 'Modules\Product\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Product
     */

    // Route for Product
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/products'], function () {
        Route::get('/', 'AdminController@getListProduct')->name('mod_product.admin.list_product');
        Route::get('/add', 'AdminController@getAddProduct')->name('mod_product.admin.add_product');
        Route::post('/add', 'AdminController@postAddProduct')->name('mod_product.admin.post_add_product');
        Route::get('/edit/{id}', 'AdminController@getEditProduct')->name('mod_product.admin.edit_product');
        Route::post('/edit/{id}', 'AdminController@postEditProduct')->name('mod_product.admin.post_edit_product');
        Route::get('/delete/{id}', 'AdminController@getDeleteProduct')->name('mod_product.admin.delete_product');
        Route::post('/changeStatus', 'AdminController@ajaxChangeStatus')->name('mod_product.ajax.changeStatus');
        Route::post('/loadModalInsertContent', 'AdminController@ajaxModalInsertContent')->name('mod_product.ajax.loadModalInsertContent');

        // Route for Category
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'AdminController@getListCategory')->name('mod_product.admin.list_category');
            Route::post('/add', 'AdminController@postAddCategory')->name('mod_product.admin.post_add_category');
            Route::get('/edit/{id}', 'AdminController@getEditCategory')->name('mod_product.admin.edit_category');
            Route::post('/edit/{id}', 'AdminController@postEditCategory')->name('mod_product.admin.post_edit_category');
            Route::get('/delete/{id}', 'AdminController@getDeleteCategory')->name('mod_product.admin.delete_category');

            Route::post('/changeStatusCategory', 'AdminController@changeStatusCategory')->name('mod_product.ajax.changeStatusCategory');
            Route::post('/ajaxChangeOrderCategory', 'AdminController@ajaxChangeOrderCategory')->name('mod_product.admin.ajaxChangeOrderCategory');
        });
    });
});