<?php
Breadcrumbs::for('mod_library', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Thư viện', route('mod_library.admin.get_list_document'));
});
Breadcrumbs::for('mod_library.admin.get_list_category', function ($trail) {
    $trail->parent('mod_library');
    $trail->push('Danh mục', route('mod_library.admin.get_list_category'));
});
Breadcrumbs::for('mod_library.admin.get_edit_category', function ($trail, $id) {
    $trail->parent('mod_library.admin.get_list_category');
    $trail->push('Sửa danh mục #' . $id, route('mod_library.admin.get_edit_category', $id));
});
Breadcrumbs::for('mod_library.admin.get_list_document', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Danh sách tài liệu', route('mod_library.admin.get_list_document'));
});
Breadcrumbs::for('mod_library.admin.get_add_document', function ($trail) {
    $trail->parent('mod_library.admin.get_list_document');
    $trail->push('Thêm tài liệu', route('mod_library.admin.get_add_document'));
});
Breadcrumbs::for('mod_library.admin.get_edit_document', function ($trail, $id) {
    $trail->parent('mod_library.admin.get_list_document');
    $trail->push('Sửa tài liệu #' . $id, route('mod_library.admin.get_edit_document', $id));
});
Breadcrumbs::for('mod_library.admin.get_list_history', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Nhật ký tải tài liệu', route('mod_library.admin.get_list_history'));
});
Breadcrumbs::for('mod_library.admin.get_detail_document', function ($trail, $id) {
    $trail->parent('mod_library.admin.get_list_document');
    $trail->push('Thông tin tài liêu #' . $id, route('mod_library.admin.get_detail_document', $id));
});