<?php

namespace Modules\Order;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 10);
            $table->unsignedBigInteger('request_id');
            $table->unsignedInteger('staff_id')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('finish_at')->nullable();
            $table->timestamp('process_at')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orders_activity_log', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('staff_id');
            $table->string('action');
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Order' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('orders_activity_log');
        Schema::dropIfExists('orders');
        Module::where('name', 'Order')->delete();
    }
}
