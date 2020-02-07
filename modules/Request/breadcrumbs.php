<?php
Breadcrumbs::for('mod_request.admin.list_request', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Yêu cầu', route('mod_request.admin.list_request'));
});
Breadcrumbs::for('mod_request.admin.add_request', function ($trail) {
    $trail->parent('mod_request.admin.list_request');
    $trail->push('Tạo yêu cầu', route('mod_request.admin.add_request'));
});
Breadcrumbs::for('mod_request.admin.edit_request', function ($trail, $id) {
    $trail->parent('mod_request.admin.list_request');
    $trail->push('Sửa yêu cầu #' . $id, route('mod_request.admin.edit_request', $id));
});
Breadcrumbs::for('mod_request.admin.detail_request', function ($trail, $id) {
    $trail->parent('mod_request.admin.list_request');
    $trail->push('Chi tiết yêu cầu #' . $id, route('mod_request.admin.detail_request', $id));
});