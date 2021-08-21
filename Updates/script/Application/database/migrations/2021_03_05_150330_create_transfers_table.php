<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('transfer_id', 20);
            $table->text('transferted_files');
            $table->text('email_to')->nullable();
            $table->string('email_from');
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('password')->nullable();
            $table->dateTime('expiry_time')->nullable();
            $table->integer('total_files');
            $table->string('spend_space');
            $table->integer('storage_method')->default('1');
            $table->integer('tranfer_status')->default('1');
            $table->integer('create_method');
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
        Schema::dropIfExists('transfers');
    }
}
