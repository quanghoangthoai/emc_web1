<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_widgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module')->default('Admin');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('group');
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('order')->default(0);
            $table->text('config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_widgets');
    }
}