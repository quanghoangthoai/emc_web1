<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * @var array
     */
    protected $fillable = [
        'lang',
        'title',
    ];

    public function items()
    {
        return $this->hasMany(Menuitem::class, 'menu_id');
    }
}