<?php
Breadcrumbs::for('mod_contact.admin.list_contact', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Liên hệ', route('mod_contact.admin.list_contact'));
});

Breadcrumbs::for('mod_contact.admin.viewcontact', function ($trail, $id) {
    $trail->parent('mod_contact.admin.list_contact');
    $trail->push('#' . $id, route('mod_contact.admin.viewcontact', $id));
});

Breadcrumbs::for('mod_contact.admin.config', function ($trail) {
    $trail->parent('mod_contact.admin.list_contact');
    $trail->push('Cấu hình', route('mod_contact.admin.config'));
});
