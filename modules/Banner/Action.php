<?php

namespace Modules\Banner;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('block_id');
            $table->string('title', 255);
            $table->string('file_src')->nullable();
            $table->string('file_alt')->nullable();
            $table->string('link')->nullable();
            $table->string('target')->default('_blank');
            $table->timestamp('begin_time')->nullable();
            $table->timestamp('expired_time')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('clicks')->default(0);
            $table->unsignedInteger('order')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
        Schema::create('banner_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 5)->default('vi');
            $table->string('title', 255);
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('form')->default(1);
            $table->unsignedInteger('width')->default(0);
            $table->unsignedInteger('height')->default(0);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Banner' . DIRECTORY_SEPARATOR . 'info.json'));
        $max_order = Module::max('order');
        Module::create([
            'name' => $content['name'],
            'title' => $content['title'],
            'version' => $content['version'],
            'description' => $content['description'],
            'order' => $max_order ? $max_order + 1 : 1
        ]);
    }

    // execute install module
    public static function uninstall()
    {
        Schema::dropIfExists('banners');
        Schema::dropIfExists('banner_blocks');
        Module::where('name', 'Banner')->delete();
    }
}