<?php

Route::group(['module' => 'Ticket', 'namespace' => 'Modules\Ticket\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Ticket
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/tickets'], function () {
        //Route for Tickket
        Route::get('/', 'AdminController@getListTicket')->name('mod_ticket.admin.list_ticket');
        Route::get('/detail/{id}', 'AdminController@getDetailTicket')->name('mod_ticket.admin.detail_ticket');
        Route::post('/detail/{id}', 'AdminController@postDetailTicket')->name('mod_ticket.admin.post_detail_ticket');
        Route::get('/delete/{id}', 'AdminController@getDeleteTicket')->name('mod_ticket.admin.delete_ticket');
        Route::get('/detail/getContentReply/{id}', 'AdminController@getContentReply');
        Route::get('/history/{reply_at}', 'AdminController@getDetailHistory')->name('mod_ticket.admin.detail_history');
        Route::get('/download/{file}', 'AdminController@getDownload')->name('mod_ticket.admin.download');
        Route::get('create-ticket', 'AdminController@getCreateTicket')->name('mod_ticket.admin.create_ticket');
        Route::post('create-ticket', 'AdminController@postCreateTicket')->name('mod_ticket.admin.post_create_ticket');
        Route::get('/downloadfilemanager/{file}', 'AdminController@getDownloadFileManager')->name('mod_ticket.admin.downloadfilemanager');
        Route::post('/ajaxChangeStatusTicket', 'AdminController@ajaxChangeStatusTicket')->name('mod_ticket.ajax.changeStatusTicket');
        Route::post('/ajaxLoadProductFromEmail', 'AdminController@ajaxLoadProductFromEmail')->name('mod_ticket.ajax.loadproductfromemail');
        // Route for Category
        Route::group(['prefix' => '/categories'], function () {
            Route::get('/', 'AdminController@getListCategory')->name('mod_ticket.admin.list_category');
            Route::post('/', 'AdminController@postAddCategory')->name('mod_ticket.admin.post_add_category');
            Route::get('/edit/{id}', 'AdminController@getEditCategory')->name('mod_ticket.admin.edit_category');
            Route::post('/edit/{id}', 'AdminController@postEditCategory')->name('mod_ticket.admin.post_edit_category');
            Route::get('/delete/{id}', 'AdminController@getDeleteCategory')->name('mod_ticket.admin.delete_category');
            Route::post('/changeStatusCategory', 'AdminController@changeStatusCategory')->name('mod_ticket.ajax.changeStatusCategory');
            Route::post('/ajaxChangeOrderCategory', 'AdminController@ajaxChangeOrderCategory')->name('mod_ticket.admin.ajaxChangeOrderCategory');
        });

        // Route for ReplyTemplate
        Route::group(['prefix' => '/reply-templates'], function () {
            Route::get('/', 'AdminController@getListReplyTemplate')->name('mod_ticket.admin.list_replytemplate');
            Route::post('/', 'AdminController@postAddReplyTemplate')->name('mod_ticket.admin.post_add_replytemplate');
            Route::get('/edit/{id}', 'AdminController@getEditReplyTemplate')->name('mod_ticket.admin.edit_replytemplate');
            Route::post('/edit/{id}', 'AdminController@postEditReplyTemplate')->name('mod_ticket.admin.post_edit_replytemplate');
            Route::get('/delete/{id}', 'AdminController@getDeleteReplyTemplate')->name('mod_ticket.admin.delete_replytemplate');
            Route::post('/ajaxChangeOrderReplyTemplate', 'AdminController@ajaxChangeOrderReplyTemplate')->name('mod_ticket.admin.ajaxChangeOrderReplyTemplate');
        });
    });
    // Route for Client
    Route::group(['middleware' => ['web', 'auth'], 'prefix' => '/clients'], function () {
        //Client  getAddTicket
        Route::get('/add-ticket', 'ClientController@getAddTicket')->name('client.add_ticket');
        Route::post('/add-ticket', 'ClientController@postAddTicket')->name('client.post_add_ticket');
        //Client getTickets
        Route::get('/detail-ticket/{id}', 'ClientController@getDetailTicket')->name('client.detail_ticket');
        Route::post('/detail-ticket/{id}', 'ClientController@postDetailTicket')->name('client.post_detail_ticket');
        //Client getTickets
        Route::get('/tickets', 'ClientController@getTickets')->name('client.tickets');
        //Client download
        Route::get('/ticket-download/{file}', 'ClientController@getDownloadTicket')->name('client.download_ticket');
    });
});
