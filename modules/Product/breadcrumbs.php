<?php
Breadcrumbs::for('mod_product.admin.list_category', function ($trail) {
    $trail->parent('mod_product.admin.list_product');
    $trail->push('Danh mục', route('mod_product.admin.list_category'));
});

Breadcrumbs::for('mod_product.admin.edit_category', function ($trail, $id) {
    $trail->parent('mod_product.admin.list_category');
    $trail->push('#' . $id, route('mod_product.admin.edit_category', $id));
});

Breadcrumbs::for('mod_product.admin.list_product', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Sản phẩm', route('mod_product.admin.list_product'));
});
Breadcrumbs::for('mod_product.admin.add_product', function ($trail) {
    $trail->parent('mod_product.admin.list_product');
    $trail->push('Thêm', route('mod_product.admin.add_product'));
});
Breadcrumbs::for('mod_product.admin.edit_product', function ($trail, $id) {
    $trail->parent('mod_product.admin.list_product');
    $trail->push('#' . $id, route('mod_product.admin.edit_product', $id));
});