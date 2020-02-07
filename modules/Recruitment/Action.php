<?php

namespace Modules\Recruitment;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::dropIfExists('recruitments');
        Schema::dropIfExists('email-templates');
        Schema::dropIfExists('progresses');
        Schema::dropIfExists('recruitment_jobs');

        Schema::create('recruitments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('position', 255)->nullable();
            $table->unsignedInteger('job_id');
            $table->string('attach_file', 255);
            $table->timestamps();
        });

        Schema::create('progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('recruitment_id');
            $table->unsignedInteger('status')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        Schema::create('email-templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('modified_by')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        Schema::create('recruitment_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 5)->default('vi');
            $table->unsignedInteger('order')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('position', 255);
            $table->string('work_address', 255);
            $table->string('work_type', 255);
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('people_number');
            $table->string('salary')->nullable();
            $table->string('link')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->text('description')->nullable();
            $table->longText('content');
            $table->text('contact_info');
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_image')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Recruitment' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('recruitments');
        Schema::dropIfExists('email-templates');
        Schema::dropIfExists('progresses');
        Module::where('name', 'Recruitment')->delete();
    }
}