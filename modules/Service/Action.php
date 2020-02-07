<?php

namespace Modules\Service;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('description')->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_image')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->unsignedInteger('category_id');
            $table->string('description')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('totalhits')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('featured')->default(0);
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_image')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Service' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
        Module::where('name', 'Service')->delete();
    }
}