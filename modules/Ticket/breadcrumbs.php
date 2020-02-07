<?php
// breadcrumbs ticket

Breadcrumbs::for('mod_ticket.admin.list_ticket', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Yêu cầu hỗ trợ', route('mod_ticket.admin.list_ticket'));
});

Breadcrumbs::for('mod_ticket.admin.create_ticket', function ($trail) {
    $trail->parent('mod_ticket.admin.list_ticket');
    $trail->push('Tạo mới yêu cầu', route('mod_ticket.admin.create_ticket'));
});

Breadcrumbs::for('mod_ticket.admin.detail_ticket', function ($trail, $id) {
    $trail->parent('mod_ticket.admin.list_ticket');
    $trail->push('Chi tiết yêu cầu #' . $id, route('mod_ticket.admin.detail_ticket', $id));
});

// breadcrumbs Category

Breadcrumbs::for('mod_ticket.admin.list_category', function ($trail) {
    $trail->parent('mod_ticket.admin.list_ticket');
    $trail->push('Quản lý hạng mục', route('mod_ticket.admin.list_category'));
});

Breadcrumbs::for('mod_ticket.admin.edit_category', function ($trail, $id) {
    $trail->parent('mod_ticket.admin.list_ticket');
    $trail->push('Hạng mục #' . $id, route('mod_ticket.admin.edit_category', $id));
});


// breadcrumbs Reply Template

Breadcrumbs::for('mod_ticket.admin.list_replytemplate', function ($trail) {
    $trail->parent('mod_ticket.admin.list_ticket');
    $trail->push('Quản lý mẫu phản hồi', route('mod_ticket.admin.list_replytemplate'));
});

Breadcrumbs::for('mod_ticket.admin.edit_replytemplate', function ($trail, $id) {
    $trail->parent('mod_ticket.admin.list_ticket');
    $trail->push('Mẫu phản hồi #' . $id, route('mod_ticket.admin.edit_replytemplate', $id));
});
