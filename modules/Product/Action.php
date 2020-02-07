<?php

namespace Modules\Product;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use System\Core\Models\Module;

class Action
{
    public static function install()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 5)->default('vi');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('name', 255);
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('price')->nullable();
            $table->string('unit_type')->nullable();
            $table->unsignedTinyInteger('enable_sale')->default(0);
            $table->string('sale_price')->nullable();
            $table->timestamp('sale_begintime')->nullable();
            $table->timestamp('sale_endtime')->nullable();
            $table->unsignedTinyInteger('featured')->default(0);
            $table->unsignedTinyInteger('display_price')->default(1);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lang', 5)->default('vi');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        $content = cms_readFileJSON(base_path('modules' . DIRECTORY_SEPARATOR . 'Product' . DIRECTORY_SEPARATOR . 'info.json'));
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
        Module::where('name', 'Product')->delete();
    }
}