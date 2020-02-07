<?php

namespace Modules\Menu;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('title', 255);
            $table->string('long_title', 255)->nullable();
            $table->text('content')->nullable();
            $table->text('link');
            $table->unsignedInteger('order');
            $table->string('module')->nullable();
            $table->string('target')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Menu' . DIRECTORY_SEPARATOR . 'info.json'));
        $max_order = Module::max('order');
        Module::create([
            'name' => $content['name'],
            'title' => $content['title'],
            'version' => $content['version'],
            'description' => $content['description'],
            'order' => $max_order ? $max_order + 1 : 1
        ]);
    }

    public static function uninstall()
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_items');
        Module::where('name', 'Menu')->delete();
    }
}