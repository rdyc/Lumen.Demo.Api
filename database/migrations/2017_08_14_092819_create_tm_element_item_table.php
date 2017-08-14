<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmElementItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_element_item', function (Blueprint $table) {
            $table->increments('element_item_id');
            $table->integer('element_id');
            $table->string('item', 225);
            $table->string('score', 225);
            $table->boolean('fl_status');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_element_item');
    }
}
