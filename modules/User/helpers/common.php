<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\User\Models\Userinfo;

function check_add_superadmin()
{
    if (User::count() == 0) {
        $user = User::create([
            'email' => 'info@emc.vn',
            'name' => 'Administrator',
            'password' => Hash::make('123456'),
            'created_at' => Carbon::now()
        ]);
        Userinfo::create(['user_id' => $user['id']]);
        $user->assignRole('superadmin');
        $user->syncPermissions(null);
    }
}

function user_display_name($uid = null)
{
    $user = $uid ? User::find($uid, ['display_name', 'email']) : auth('web')->user();
    if ($user) {
        return $user['display_name'] ? $user['display_name'] : $user['email'];
    }
    return '';
}