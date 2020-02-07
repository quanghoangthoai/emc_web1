<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Menuitem extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'link',
        'order',
        'module',
        'target',
        'long_title',
        'content',
        'status',
    ];

    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}