<?php

namespace Modules\Comment\Models;

use Illuminate\Database\Eloquent\Model;

class CommentModule extends Model
{
    protected $table = 'comments_modules';
    protected $fillable = ['name', 'status'];
}
