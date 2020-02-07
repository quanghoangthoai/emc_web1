<?php

Route::group(['module' => 'Recruitment', 'namespace' => 'Modules\Recruitment\Controllers'], function () {
    /**
     * ROUTES FOR ADMIN: Recruitment
     */
    Route::group(['middleware' => ['admin'], 'prefix' => config('cms.admin_prefix') . '/recruitments'], function () {

        Route::get('/', 'AdminController@getListRecruitment')->name('mod_recruitment.admin.list_recruitment');
        Route::get('/detail/{id}', 'AdminController@getDetailRecruitment')->name('mod_recruitment.admin.detail_recruitment');
        Route::post('/detail/sendmail/{id}', 'AdminController@postSendMail')->name('mod_recruitment.admin.send_mail_recruitment');

        Route::get('/delete/{id}', 'AdminController@getDeleteRecruitment')->name('mod_recruitment.admin.delete_recruitment');
        Route::post('/response', 'AdminController@postResponseRecruitment')->name('mod_recruitment.admin.post_response_recruitment');
        Route::get('/download/recruitment_doc/{id}', 'AdminController@getDownload')->name('mod_recruitment.admin.get_download');
        Route::get('/test/{id}', 'AdminController@getTestRecruitment')->name('mod_recruitment.admin.test');
        Route::post('/test/{id}', 'AdminController@postTestRecruitment')->name('mod_recruitment.admin.post_test');

        Route::group(['prefix' => '/email-templates'], function () {
            Route::get('/', 'AdminController@getListEmailTemplate')->name('mod_recruitment.admin.list_email_template');
            Route::post('/add', 'AdminController@postAddEmailTemplate')->name('mod_recruitment.admin.post_add_email_template');
            Route::get('/edit/{id}', 'AdminController@getEditEmailTemplate')->name('mod_recruitment.admin.edit_email_template');
            Route::post('/edit/{id}', 'AdminController@postEditEmailTemplate')->name('mod_recruitment.admin.post_edit_email_template');
            Route::get('/delete/{id}', 'AdminController@getDeleteEmailTemplate')->name('mod_recruitment.admin.delete_email_template');
            route::post('/ajaxshowtemplate', 'AdminController@ajaxShowMailTemplate')->name('mod_recruitment.admin.ajaxshowmailtemplate');
        });

        Route::group(['prefix' => '/jobs'], function () {
            Route::get('/', 'AdminController@getListJob')->name('mod_recruitment.admin.list_job');
            Route::get('/add', 'AdminController@getAddJob')->name('mod_recruitment.admin.add_job');
            Route::post('/add', 'AdminController@postAddJob')->name('mod_recruitment.admin.post_add_job');
            Route::get('/edit/{id}', 'AdminController@getEditJob')->name('mod_recruitment.admin.edit_job');
            Route::post('/edit/{id}', 'AdminController@postEditJob')->name('mod_recruitment.admin.post_edit_job');
            Route::get('/delete/{id}', 'AdminController@getDeleteJob')->name('mod_recruitment.admin.delete_job');
            Route::post('/changejob', 'AdminController@ajaxChangjob')->name('mod_recruitment.ajax.changeJob');
            Route::post('/changeStatus', 'AdminController@ajaxChangeStatus')->name('mod_recruitment.ajax.changeStatus');
        });
    });
});