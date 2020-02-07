<?php

Breadcrumbs::for('mod_banner.admin.listallbanner', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quảng cáo', route('mod_banner.admin.listallbanner'));
});
Breadcrumbs::for('mod_banner.admin.addblock', function ($trail) {
    $trail->parent('mod_banner.admin.listallbanner');
    $trail->push('Thêm khối', route('mod_banner.admin.addblock'));
});
Breadcrumbs::for('mod_banner.admin.listblock', function ($trail) {
    $trail->parent('mod_banner.admin.listallbanner');
    $trail->push('DS khối', route('mod_banner.admin.listblock'));
});
Breadcrumbs::for('mod_banner.admin.editblock', function ($trail, $id) {
    $trail->parent('mod_banner.admin.listallbanner');
    $trail->push('Sửa khối', route('mod_banner.admin.editblock', $id));
});
Breadcrumbs::for('mod_banner.admin.addbanner', function ($trail) {
    $trail->parent('mod_banner.admin.listallbanner');
    $trail->push('Thêm QC', route('mod_banner.admin.addbanner'));
});
Breadcrumbs::for('mod_banner.admin.editbanner', function ($trail, $id) {
    $trail->parent('mod_banner.admin.listallbanner');
    $trail->push('Sửa QC', route('mod_banner.admin.editbanner', $id));
});