<?php

use Modules\Menu\Models\Menu;
use Modules\Menu\Models\Menuitem;

Breadcrumbs::for('mod_menu', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý menu', route('mod_menu.admin.list_menu'));
});

Breadcrumbs::for('mod_menu.admin.list_menu', function ($trail) {
    $trail->parent('mod_menu');
    $trail->push('Khối menu', route('mod_menu.admin.list_menu'));
});

Breadcrumbs::for('mod_menu.admin.add_menu', function ($trail) {
    $trail->parent('mod_menu.admin.list_menu');
    $trail->push('Thêm khối ', route('mod_menu.admin.add_menu'));
});

Breadcrumbs::for('mod_menu.admin.edit_menu', function ($trail, $id) {
    $trail->parent('mod_menu.admin.list_menu');
    $trail->push('Khối #' . $id, route('mod_menu.admin.edit_menu', $id));
});

Breadcrumbs::for('mod_menu.admin.list_menu_item', function ($trail, $id) {
    $trail->parent('mod_menu.admin.list_menu');
    $trail->push('Khối #' . $id, route('mod_menu.admin.list_menu_item', $id));
});

Breadcrumbs::for('mod_menu.admin.add_menu_item', function ($trail, $id) {
    $trail->parent('mod_menu.admin.list_menu_item', $id);
    $trail->push('Thêm menu', route('mod_menu.admin.add_menu_item', $id));
});

Breadcrumbs::for('mod_menu.admin.edit_item', function ($trail, $id) {
    $menu_item = Menuitem::find($id);
    $trail->parent('mod_menu.admin.list_menu_item', $menu_item->menu_id);
    $trail->push('Sửa menu #' . $id, route('mod_menu.admin.edit_item', $id));
});