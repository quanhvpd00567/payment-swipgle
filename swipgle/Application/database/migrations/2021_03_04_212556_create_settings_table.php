<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id');
            $table->string('website_name');
            $table->string('google_analytics')->nullable();
            $table->string('logo');
            $table->string('favicon');
            $table->string('home_heading');
            $table->text('home_description');
            $table->integer('website_storage');
            $table->string('website_currency');
            $table->integer('max_files');
            $table->string('website_main_color');
            $table->string('website_sec_color');
            $table->string('free_storage')->default('0');
            $table->text('home_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
