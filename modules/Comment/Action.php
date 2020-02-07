<?php

namespace Modules\Comment;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('module_id')->unsigned()->nullable();
            $table->integer('user_parent_id')->unsigned()->nullable();
            $table->text('body');
            $table->integer('commentable_id')->nullable();
            $table->string('commentable_type')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comments_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Comment' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('comments');
        Schema::dropIfExists('comments_modules');
        Module::where('name', 'Comment')->delete();
    }
}
