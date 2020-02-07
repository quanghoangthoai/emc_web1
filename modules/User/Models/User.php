<?php

namespace Modules\User\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'email_verified_at',
        'password',
        'display_name',
        'remember_token',
        'status'
    ];

    public function info()
    {
        return $this->hasOne(Userinfo::class, 'user_id');
    }

    public function social()
    {
        return $this->hasMany(UserSocial::class, 'user_id');
    }
}