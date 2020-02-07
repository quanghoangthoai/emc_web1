<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_social';

    /**
     * @var array
     */
    protected $fillable = [
        'provider',
        'social_id',
        'user_id',
        'avatar',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}