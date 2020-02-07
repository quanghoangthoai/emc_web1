<?php

Route::group(['middleware' => ['admin'], 'namespace' => 'System\Admin\Controllers', 'prefix' => config('cms.admin_prefix')], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::post('/save-widget-admin', 'DashboardController@saveWidgetAdmin')->name('cms.admin.post_save_widget');

    // Routes for Notification
    Route::group(['prefix' => 'notifications'], function () {
        Route::get('', 'NotificationController@getList')->name('cms.admin.list_notification');
        Route::post('/ajaxLoad', 'NotificationController@ajaxLoad')->name('cms.ajax.loadNotification');
        Route::post('/bulkaction', 'NotificationController@postBulkaction')->name('cms.admin.bulkaction_notification');
    });

    // Routes for Notification
    Route::group(['prefix' => 'addons'], function () {
        Route::get('/', 'AddonsController@getAddons')->name('cms.admin.addons');
        Route::post('/', 'AddonsController@postAddons')->name('cms.admin.post_addons');
    });

    // Routes for Layouts
    Route::group(['prefix' => 'layouts'], function () {
        Route::get('/', 'LayoutController@getLayouts')->name('cms.admin.layouts');
        Route::post('/', 'LayoutController@ajaxSaveLayout')->name('cms.admin.ajax_layout');
    });

    // Routes for Email Templates
    Route::group(['prefix' => 'email-templates'], function () {
        Route::get('/', 'EmailTemplateController@getList')->name('cms.admin.list_email_templates');
        Route::get('/{id}', 'EmailTemplateController@getEdit')->name('cms.admin.edit_email_template');
        Route::post('/{id}', 'EmailTemplateController@postEdit')->name('cms.admin.post_edit_email_template');
    });

    /**
     * Routes for Module Manager
     */
    Route::group(['prefix' => 'modules'], function () {
        Route::get('/', 'ModuleController@getListModule')->name('cms.admin.list_module');
        Route::get('/install/{module}', 'ModuleController@getInstallModule')->name('cms.admin.install_module');
        Route::get('/uninstall/{module}', 'ModuleController@getUninstallModule')->name('cms.admin.uninstall_module');
        Route::get('/edit/{name}', 'ModuleController@getEditModule')->name('cms.admin.edit_module');
        Route::post('/edit/{name}', 'ModuleController@postEditModule')->name('cms.admin.postedit_module');
        Route::post('/ajaxChangeStatus', 'ModuleController@ajaxChangeStatus')->name('cms.admin.ajaxchangestatus_module');
        Route::post('/ajaxChangeOrderModule', 'ModuleController@ajaxChangeOrderModule')->name('cms.admin.ajaxChangeOrderModule');
    });

    /**
     * Routes for Activity logs
     */
    Route::group(['prefix' => 'activity-logs'], function () {
        Route::get('/', 'ActivityLogController@getList')->name('cms.admin.list_activity_log');
        Route::get('/deleteAll', 'ActivityLogController@getDeleteAll')->name('cms.admin.delete_all_activity_log');
    });

    /**
     * Routes for Settings
     */
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingController@getSettingInfo')->name('cms.admin.setting_info');
        Route::post('/', 'SettingController@postSettingInfo')->name('cms.admin.postsetting_info');
        Route::get('/system', 'SettingController@getSettingSystem')->name('cms.admin.setting_system');
        Route::post('/system', 'SettingController@postSettingSystem')->name('cms.admin.postsetting_system');

        Route::post('/ajaxSendTestConfigMail', 'SettingController@ajaxSendTestConfigMail')->name('cms.admin.ajaxSendTestConfigMail');
    });

    /**
     * Routes for File-manager
     */
    Route::group(['prefix' => 'files'], function () {
        Route::get('/', 'FileController@getMain')->name('cms.admin.files');
    });

    /**
     * Routes for Backup/Restore
     */
    Route::group(['prefix' => 'backups'], function () {
        Route::get('/', 'BackupController@getListBackup')->name('cms.admin.list_backup');
        Route::get('/run', 'BackupController@getRunBackup')->name('cms.admin.run_backup');
        Route::get('/download/{filename}', 'BackupController@getDownloadBackup')->name('cms.admin.download_backup');
        Route::get('/delete/{filename}', 'BackupController@getDeleteBackup')->name('cms.admin.delete_backup');
    });

    /**
     * Routes for Roles/Permissions
     */
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RoleController@getListRole')->name('cms.admin.list_role');
        Route::get('/add', 'RoleController@getAddRole')->name('cms.admin.add_role');
        Route::post('/add', 'RoleController@postAddRole')->name('cms.admin.post_add_role');
        Route::get('/edit/{id}', 'RoleController@getEditRole')->name('cms.admin.edit_role');
        Route::post('/edit/{id}', 'RoleController@postEditRole')->name('cms.admin.post_edit_role');
        Route::get('/delete/{id}', 'RoleController@getDeleteRole')->name('cms.admin.delete_role');
        Route::post('/ajaxChangeOrdeRole', 'RoleController@ajaxChangeOrdeRole')->name('cms.admin.ajax_change_order_role');
    });

    // Permissions
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', 'PermissionController@getList')->name('cms.admin.list_permission');
        Route::get('/add', 'PermissionController@getAdd')->name('cms.admin.add_permission');
        Route::post('/add', 'PermissionController@postAdd')->name('cms.admin.post_add_permission');
        Route::get('/edit/{id}', 'PermissionController@getEdit')->name('cms.admin.edit_permission');
        Route::post('/edit/{id}', 'PermissionController@postEdit')->name('cms.admin.post_edit_permission');
        Route::get('/delete/{id}', 'PermissionController@getDelete')->name('cms.admin.delete_permission');

        Route::post('/syncpermissions', 'PermissionController@ajaxSyncPermissions')->name('cms.admin.ajaxsyncpermissions');
    });

    // Routes for widgets
    Route::group(['prefix' => 'widgets'], function () {
        Route::get('/', 'WidgetController@getList')->name('cms.admin.list_widget');
        Route::get('/add', 'WidgetController@getAdd')->name('cms.admin.add_widget');
        Route::post('/add', 'WidgetController@postAdd')->name('cms.admin.post_add_widget');
        Route::get('/edit/{id}', 'WidgetController@getEdit')->name('cms.admin.edit_widget');
        Route::post('/edit/{id}', 'WidgetController@postEdit')->name('cms.admin.post_edit_widget');
        Route::get('/delete/{id}', 'WidgetController@getDelete')->name('cms.admin.delete_widget');

        Route::post('/change-widget', 'WidgetController@ajaxChangStatusWidget')->name('cms.admin.ajaxChangeStatusWidget');
        Route::post('/load-widget-module', 'WidgetController@ajaxLoadWidgetModule')->name('cms.admin.ajaxLoadWidgetModule');
        Route::post('/load-config-widget', 'WidgetController@ajaxLoadConfigWidget')->name('cms.admin.ajaxLoadConfigWidget');

        Route::post('/load-add-widget', 'WidgetController@ajaxLoadAddWidget')->name('cms.admin.ajaxLoadAddWidget');
        Route::post('/load-widget-to-group', 'WidgetController@ajaxLoadWidgetToGroup')->name('cms.admin.ajaxLoadWidgetToGroup');
        Route::post('/submit-add-widget', 'WidgetController@ajaxSubmitAddWidget')->name('cms.admin.ajaxSubmitAddWidget');
        Route::post('/submit-update-widget', 'WidgetController@ajaxSubmitUpdateWidget')->name('cms.admin.ajaxSubmitUpdateWidget');
        Route::post('/submit-delete-widget', 'WidgetController@ajaxSubmitDeleteWidget')->name('cms.admin.ajaxSubmitDeleteWidget');
        Route::post('/update-position-widget', 'WidgetController@ajaxUpdatePositionWidget')->name('cms.admin.ajaxUpdatePositionWidget');
    });
});