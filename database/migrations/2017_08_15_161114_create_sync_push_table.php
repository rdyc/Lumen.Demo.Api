<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncPushTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sync_push', function (Blueprint $table) {
            $table->increments('sync_id');
            $table->string('sync_version');
            $table->string('sync_client');
            $table->integer('sync_size');
            $table->string('sync_path');
            $table->boolean('sync_is_complete');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('sync_push');
    }
}
