<?php
Breadcrumbs::for('mod_service.admin.list_service', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Dịch vụ', route('mod_service.admin.list_service'));
});

Breadcrumbs::for('mod_service.admin.add_service', function ($trail) {
    $trail->parent('mod_service.admin.list_service');
    $trail->push('Thêm dịch vụ', route('mod_service.admin.add_service'));
});
Breadcrumbs::for('mod_service.widget.chart', function ($trail) {
    $trail->parent('mod_service.admin.list_service');
    $trail->push('Biểu đồ', route('mod_service.widget.chart'));
});

Breadcrumbs::for('mod_service.admin.edit_service', function ($trail, $id) {
    $trail->parent('mod_service.admin.list_service');
    $trail->push('#' . $id, route('mod_service.admin.edit_service', $id));
});

Breadcrumbs::for('mod_service.admin.list_category', function ($trail) {
    $trail->parent('mod_service.admin.list_service');
    $trail->push('Danh mục', route('mod_service.admin.list_category'));
});

Breadcrumbs::for('mod_service.admin.edit_category', function ($trail, $id) {
    $trail->parent('mod_service.admin.list_category');
    $trail->push('#' . $id, route('mod_service.admin.edit_category', $id));
});
