<?php
Breadcrumbs::for('mod_page.admin.list_page', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Trang', route('mod_page.admin.list_page'));
});

Breadcrumbs::for('mod_page.admin.add_page', function ($trail) {
    $trail->parent('mod_page.admin.list_page');
    $trail->push('Thêm', route('mod_page.admin.add_page'));
});

Breadcrumbs::for('mod_page.admin.edit_page', function ($trail, $id) {
    $trail->parent('mod_page.admin.list_page');
    $trail->push('#' . $id, route('mod_page.admin.edit_page', $id));
});