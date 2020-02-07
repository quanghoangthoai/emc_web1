<?php
// init permissions
$permissions = [];

$permissions[] = [
    'name' => 'mod_post.admin.list__post',
    'title' => 'Danh sách tin tức',
    'description' => 'Xem danh sách các bài viết tin tức'
];

$permissions[] = [
    'name' => 'mod_post.admin.add__post',
    'title' => 'Thêm tin tức',
    'description' => 'Thêm tin tức mới'
];

$permissions[] = [
    'name' => 'mod_post.admin.edit__post',
    'title' => 'Sửa tin tức',
    'description' => 'Sửa đổi và cập nhật bài viết tin tức'
];

$permissions[] = [
    'name' => 'mod_post.admin.delete__post',
    'title' => 'Xóa tin tức',
    'description' => 'Quyền xóa bài viết tin tức'
];


$permissions[] = [
    'name' => 'mod_post.admin.list__category',
    'title' => 'Danh sách danh mục tin tức',
    'description' => 'Xem danh sách danh mục tin tức'
];

$permissions[] = [
    'name' => 'mod_post.admin.add__category',
    'title' => 'Thêm danh mục tin tức',
    'description' => 'Thêm danh mục tin tức mới'
];

$permissions[] = [
    'name' => 'mod_post.admin.edit__category',
    'title' => 'Sửa danh mục tin tức',
    'description' => 'Sửa đổi và cập nhật danh mục tin tức'
];

$permissions[] = [
    'name' => 'mod_post.admin.delete__category',
    'title' => 'Xóa danh mục tin tức',
    'description' => 'Quyền xóa danh mục tin tức'
];

$permissions[] = [
    'name' => 'mod_post.admin.post_config',
    'title' => 'Cầu hình',
    'description' => 'Chỉnh sửa và cập nhật cấu hình module'
];
