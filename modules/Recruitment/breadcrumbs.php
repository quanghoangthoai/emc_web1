<?php

/**
 * Breadcrumb for Recruitment
 */

Breadcrumbs::for('mod_recruitment', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tuyển dụng', route('mod_recruitment.admin.list_recruitment'));
});
Breadcrumbs::for('mod_recruitment.admin.list_recruitment', function ($trail) {
    $trail->parent('mod_recruitment');
    $trail->push('Hồ sơ ứng tuyển', route('mod_recruitment.admin.list_recruitment'));
});

Breadcrumbs::for('mod_recruitment.admin.detail_recruitment', function ($trail, $id) {
    $trail->parent('mod_recruitment.admin.list_recruitment');
    $trail->push('#' . $id, route('mod_recruitment.admin.detail_recruitment', $id));
});

/**
 * Breadcrumb for Mail Template
 */

Breadcrumbs::for('mod_recruitment.admin.list_email_template', function ($trail) {
    $trail->parent('mod_recruitment');
    $trail->push('Mẫu phản hồi', route('mod_recruitment.admin.list_email_template'));
});

Breadcrumbs::for('mod_recruitment.admin.edit_email_template', function ($trail, $id) {
    $trail->parent('mod_recruitment.admin.list_email_template');
    $trail->push('#' . $id, route('mod_recruitment.admin.edit_email_template', $id));
});

/**
 * Breadcrumb for Job
 */
Breadcrumbs::for('mod_recruitment.admin.add_job', function ($trail) {
    $trail->parent('mod_recruitment.admin.list_job');
    $trail->push('Đăng tin', route('mod_recruitment.admin.add_job'));
});

Breadcrumbs::for('mod_recruitment.admin.list_job', function ($trail) {
    $trail->parent('mod_recruitment');
    $trail->push('Tin tuyển dụng', route('mod_recruitment.admin.list_job'));
});
Breadcrumbs::for('mod_recruitment.admin.edit_job', function ($trail, $id) {
    $trail->parent('mod_recruitment.admin.list_job');
    $trail->push('#' . $id, route('mod_recruitment.admin.edit_job', $id));
});

Breadcrumbs::for('mod_recruitment.admin.test', function ($trail, $id) {
    $trail->parent('mod_recruitment.admin.list_job');
    $trail->push('Kiểm thử tin tuyển dụng #' . $id, route('mod_recruitment.admin.test', $id));
});