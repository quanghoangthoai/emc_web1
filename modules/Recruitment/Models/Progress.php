<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = [
        'id',
        'user_id',
        'recruitment_id',
        'status',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class, 'recruitment_id');
    }
}
