<?php
// breadcrumbs for module
Breadcrumbs::for('mod_comment.admin.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Quản lý module bình luận', route('mod_comment.admin.list'));
});

// breadcrumbs for comment

Breadcrumbs::for('mod_comment.admin.list_comment', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Danh sách bình luận', route('mod_comment.admin.list_comment'));
});
