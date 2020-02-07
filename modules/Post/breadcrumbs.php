<?php

Breadcrumbs::for('mod_post.admin.list_post', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Bài viết', route('mod_post.admin.list_post'));
});

Breadcrumbs::for('mod_post.admin.list_category', function ($trail) {
    $trail->parent('mod_post.admin.list_post');
    $trail->push('Danh mục', route('mod_post.admin.list_category'));
});

Breadcrumbs::for('mod_post.admin.edit_category', function ($trail, $id) {
    $trail->parent('mod_post.admin.list_category');
    $trail->push('#' . $id, route('mod_post.admin.edit_category', $id));
});

Breadcrumbs::for('mod_post.admin.add_post', function ($trail) {
    $trail->parent('mod_post.admin.list_post');
    $trail->push('Thêm', route('mod_post.admin.add_post'));
});

Breadcrumbs::for('mod_post.admin.edit_post', function ($trail, $id) {
    $trail->parent('mod_post.admin.list_post');
    $trail->push('#' . $id, route('mod_post.admin.edit_post', $id));
});