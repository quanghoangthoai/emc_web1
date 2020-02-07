<?php

namespace System\Core\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_templates';

    /**
     * @var array
     */
    protected $fillable = [
        'lang',
        'module',
        'name',
        'title',
        'description',
        'mail_title',
        'mail_content',
        'variables',
    ];
}