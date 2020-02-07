<?php

$submenu = [];
$submenu[] = [
    'route' => 'mod_post.admin.add_post',
    'title' => 'Thêm bài viết',
    // 'permission' => 'mod_post.admin.get_add_post'
];
$submenu[] = [
    'route' => 'mod_post.admin.list_post',
    'title' => 'Danh sách bài viết',
    // 'permission' => 'mod_post.admin.get_list_new'
];
$submenu[] = [
    'route' => 'mod_post.admin.list_category',
    'title' => 'Quản lý danh mục',
    // 'permission' => 'mod_post.admin.get_list_category'
];