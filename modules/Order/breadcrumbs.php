<?php
Breadcrumbs::for('mod_order.admin.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Danh sách đơn hàng', route('mod_order.admin.list'));
});

Breadcrumbs::for('mod_order.admin.order', function ($trail, $id) {
    $trail->parent('mod_order.admin.list');
    $trail->push('Chi tiết đơn hàng', route('mod_order.admin.order', $id));
});
