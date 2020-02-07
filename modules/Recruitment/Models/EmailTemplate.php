<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email-templates';

    protected $fillable = [
        'id',
        'name',
        'content',
        'created_by',
        'modified_by',
        'modified'
    ];
}
