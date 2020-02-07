<?php

namespace Modules\Slider;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('slider_slides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('link')->nullable()->default("#");
            $table->unsignedInteger('block_id')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
        Schema::create('slider_blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Slider' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('slider_slides');
        Schema::dropIfExists('slider_blocks');
        Module::where('name', 'Slider')->delete();
    }
}