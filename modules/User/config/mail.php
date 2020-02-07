<?php

return [
    'new_user' => [
        'name' => 'new_user',
        'title' => 'Tài khoản mới',
        'description' => 'Gửi mail khi tài khoản mới được tạo',
        'variables' => [
            [
                'code' => '{email}',
                'title' => 'Email'
            ],
            [
                'code' => '{password}',
                'title' => 'Mật khẩu'
            ],
            [
                'code' => '{email}',
                'title' => 'Email'
            ],
            [
                'code' => '{fullname}',
                'title' => 'Họ tên'
            ],
            [
                'code' => '{link_callback}',
                'title' => 'Liên kết chuyển hướng'
            ]
        ]
    ]
];