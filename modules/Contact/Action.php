<?php

namespace Modules\Contact;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service')->nullable();
            $table->string('title')->nullable();
            $table->string('sender_name');
            $table->string('sender_phone')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('sender_address')->nullable();
            $table->string('sender_ip')->nullable();
            $table->text('sender_content');
            $table->unsignedInteger('reply_by')->nullable();
            $table->timestamp('reply_at')->nullable();
            $table->text('reply_content')->nullable();
            $table->text('reply_attachments')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Contact' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('contacts');
        Module::where('name', 'Contact')->delete();
    }
}
