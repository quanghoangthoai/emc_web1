<?php
Breadcrumbs::for('mod_slide.admin.list_slide', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Danh Sách Danh Mục', route('mod_slide.admin.list_slide'));
});
Breadcrumbs::for('mod_slide.admin.add_slide', function ($trail) {
    $trail->parent('mod_slide.admin.list_slide');
    $trail->push('Thêm Slide', route('mod_slide.admin.add_slide'));
});

Breadcrumbs::for('mod_slide.admin.edit_slide', function ($trail, $id) {
    $trail->parent('mod_slide.admin.list_slide');
    $trail->push('#' . $id, route('mod_slide.admin.edit_slide', $id));
});
Breadcrumbs::for('mod_block.admin.list_block', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Danh Sách Khối Hiển Thị ', route('mod_block.admin.list_block'));
});
Breadcrumbs::for('mod_block.admin.add_block', function ($trail) {
    $trail->parent('mod_block.admin.list_block');
    $trail->push('Thêm Block', route('mod_block.admin.add_block'));
});
Breadcrumbs::for('mod_block.admin.edit_block', function ($trail, $id) {
    $trail->parent('mod_block.admin.list_block');
    $trail->push('#' . $id, route('mod_block.admin.edit_block', $id));
});