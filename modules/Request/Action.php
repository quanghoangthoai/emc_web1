<?php

namespace Modules\Request;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::dropIfExists('requests');
        Schema::dropIfExists('request_products');
        Schema::dropIfExists('request_images');
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('client_name', 255)->nullable();
            $table->string('client_phone', 10);
            $table->string('client_email', 255);
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('payment');
            $table->unsignedTinyInteger('payment_method');
            $table->unsignedBigInteger('order');
            $table->longText('note')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('confirm_image')->nullable();
            $table->boolean('isOrderCreated')->default(0);
            $table->unsignedSmallInteger('vat_percent')->nullable();
            $table->unsignedSmallInteger('sale_percent')->nullable();
            $table->timestamps();
        });

        Schema::create('request_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
        });

        // Schema::create('request_images', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('path')->nullable();
        //     $table->unsignedBigInteger('request_id');
        //     $table->timestamps();
        // });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('requests');
        Schema::dropIfExists('request_products');
        Schema::dropIfExists('request_images');
        Module::where('name', 'Request')->delete();
    }
}
