<?php

Route::group(['module' => 'Comment', 'namespace' => 'Modules\Comment\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Comment
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/comments'], function () {
        Route::get('/', 'AdminController@getList')->name('mod_comment.admin.list');
        Route::get('list-commnet', 'AdminController@getListComment')->name('mod_comment.admin.list_comment');
        Route::get('/delete-comment/{id}', 'AdminController@geDeleteComment')->name('mod_comment.admin.deltete_comment');
        Route::post('/add-comment-module', 'AdminController@postAddModule')->name('mod_comment.admin.post_add_module');
        Route::get('/delete-comment-module/{id}', 'AdminController@geDeleteModule')->name('mod_comment.admin.deltete_module');
        Route::post('/changeStatusCommentModule', 'AdminController@changeStatusCommentModule')->name('mod_comment.ajax.changeStatusCommentModule');
    });
});

Route::group(['middleware' => 'web'], function () {
    Route::group(['module' => 'Comment', 'namespace' => 'Modules\Comment\Controllers'], function () {
        // load comment and add comment
        Route::get('/id/{id}/module/{module}/link/{link}', 'WebController@getLoadComment')->name('mod_comment.web.loadcomment');
        Route::post('/post-comment', 'WebController@postComment')->name('mod_comment.web.post_comment');
        Route::post('/post-comment-parent', 'WebController@postCommentParent')->name('mod_comment.web.post_comment_parent');

        // check login web
        Route::post('/login', 'WebController@postLogin')->name('mod_comment.web.post_login');
    });
});
