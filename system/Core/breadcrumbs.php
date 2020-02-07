<?php

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('<i class="icon-home2 mr-2"></i>Bảng điều khiển', route('dashboard'));
});
Breadcrumbs::for('cms.admin.setting_info', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông tin website', route('cms.admin.setting_info'));
});
Breadcrumbs::for('cms.admin.setting_system', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thiết lập hệ thống', route('cms.admin.setting_system'));
});
Breadcrumbs::for('cms.admin.files', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý file', route('cms.admin.files'));
});
Breadcrumbs::for('cms.admin.list_notification', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thông báo', route('cms.admin.list_notification'));
});

Breadcrumbs::for('cms.admin.list_module', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý module', route('cms.admin.list_module'));
});

Breadcrumbs::for('cms.admin.list_activity_log', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Nhật ký hoạt động', route('cms.admin.list_activity_log'));
});

Breadcrumbs::for('cms.admin.edit_module', function ($trail, $data) {
    $trail->parent('cms.admin.list_module');
    $trail->push('Module: "' . $data . '"', route('cms.admin.edit_module', $data));
});

Breadcrumbs::for('cms.admin.list_backup', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Sao lưu dữ liệu', route('cms.admin.list_backup'));
});

Breadcrumbs::for('cms.admin.list_role', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Vai trò', route('cms.admin.list_role'));
});

Breadcrumbs::for('cms.admin.add_role', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thêm vai trò', route('cms.admin.add_role'));
});

Breadcrumbs::for('cms.admin.edit_role', function ($trail, $id) {
    $trail->parent('cms.admin.list_role');
    $trail->push('Sửa vai trò #' . $id, route('cms.admin.edit_role', $id));
});

Breadcrumbs::for('cms.admin.list_permission', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Danh sách quyền hạn', route('cms.admin.list_permission'));
});

Breadcrumbs::for('cms.admin.list_widget', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Widget', route('cms.admin.list_widget'));
});

Breadcrumbs::for('cms.admin.addons', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý Addons', route('cms.admin.addons'));
});

Breadcrumbs::for('cms.admin.layouts', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thiết lập layout', route('cms.admin.layouts'));
});

Breadcrumbs::for('cms.admin.list_email_templates', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Mẫu email', route('cms.admin.list_email_templates'));
});

Breadcrumbs::for('cms.admin.edit_email_template', function ($trail, $id) {
    $trail->parent('cms.admin.list_email_templates');
    $trail->push('#' . $id, route('cms.admin.edit_email_template', $id));
});

// loop modules
// // requireOnce
global $active_modules;
foreach ($active_modules as $iMod) {
    if (File::exists(base_path('modules' . DIRECTORY_SEPARATOR . $iMod . DIRECTORY_SEPARATOR . 'breadcrumbs.php'))) {
        File::requireOnce(base_path('modules' . DIRECTORY_SEPARATOR . $iMod . DIRECTORY_SEPARATOR . 'breadcrumbs.php'));
    }
}