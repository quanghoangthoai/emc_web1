<?php

Breadcrumbs::for('mod_user.admin.list_department', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý phòng ban', route('mod_user.admin.list_department'));
});

Breadcrumbs::for('mod_user.admin.edit_department', function ($trail, $id) {
    $trail->parent('mod_user.admin.list_department');
    $trail->push('#' . $id, route('mod_user.admin.edit_department', $id));
});

Breadcrumbs::for('mod_user.admin.list_user', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Tài khoản', route('mod_user.admin.list_user'));
});

Breadcrumbs::for('mod_user.admin.add_user', function ($trail) {
    $trail->parent('mod_user.admin.list_user');
    $trail->push('Thêm', route('mod_user.admin.add_user'));
});

Breadcrumbs::for('mod_user.admin.edit_user', function ($trail, $id) {
    $trail->parent('mod_user.admin.list_user');
    $trail->push('#' . $id, route('mod_user.admin.edit_user', $id));
});