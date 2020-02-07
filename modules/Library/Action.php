<?php

namespace Modules\Library;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::dropIfExists('library_categories');
        Schema::dropIfExists('library_documents');
        Schema::dropIfExists('library_histories');

        Schema::create('library_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('order')->default(0);
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('name', 255);
            $table->string('slug', 255)->nullable();
            $table->unsignedTinyInteger('format_type');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('library_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 255)->nullable();
            $table->unsignedTinyInteger('document_type');
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('download_count')->default(0);
            $table->text('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('attach_file')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('text_code')->nullable();
            $table->unsignedTinyInteger('text_type')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('started_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('issued_location')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });

        Schema::create('library_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('category_id');
            $table->timestamp('download_time')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });


        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('library_categories');
        Schema::dropIfExists('library_documents');
        Schema::dropIfExists('library_histories');
        Module::where('name', 'Library')->delete();
    }
}
