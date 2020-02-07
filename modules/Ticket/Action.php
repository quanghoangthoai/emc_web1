<?php

namespace Modules\Ticket;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;
use File;

class Action
{
    public static function install()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->string('title', 255);
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('staff_id')->nullable();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('category_description', 255)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('user_id');
            $table->text('content');
            $table->text('attachments')->nullable();
            $table->timestamp('reply_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->string('name', 255);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('ticket_reply_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order')->default(0);
            $table->string('name', 255);
            $table->text('content');
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Ticket' . DIRECTORY_SEPARATOR . 'info.json'));
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
        $path = base_path('public' . DIRECTORY_SEPARATOR . 'shared' . DIRECTORY_SEPARATOR . 'Ticket');
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_categories');
        Schema::dropIfExists('ticket_reply_templates');
        Module::where('name', 'Ticket')->delete();
    }
}
