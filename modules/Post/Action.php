<?php

namespace Modules\Post;

use File;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Post' . DIRECTORY_SEPARATOR . 'info.json'));
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 5)->default('vi');
            $table->unsignedInteger('category_id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('content');
            $table->string('source')->nullable();
            $table->mediumText('attachments')->nullable();
            $table->string('tags')->nullable();
            $table->string('author')->nullable();
            $table->unsignedTinyInteger('featured')->default(0);
            $table->unsignedInteger('created_by');
            $table->timestamp('public_at')->nullable();
            $table->unsignedBigInteger('totalhits')->default(0);
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_image')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // categories
        Schema::create('post_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->string('lang', 5)->default('vi');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('featured')->default(0);
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_image')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });


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
        Schema::dropIfExists('posts');
        Module::where('name', 'Post')->delete();
    }
}