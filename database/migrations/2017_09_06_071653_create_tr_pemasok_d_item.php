<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrPemasokDItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_pemasok_d_item', function (Blueprint $table) {
            $table->uuid('pemasok_d_item_id');
            $table->uuid('pemasok_d_id');
            $table->uuid('pemasok_h_id');
            $table->bigInteger('element_item_id');
            $table->bigInteger('element_id');
            $table->string('item', 225);
            $table->string('score', 225)->nullable();
            $table->string('val', 100)->nullable();
            $table->boolean('fl_status');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('pemasok_d_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_pemasok_d_item');
    }
}
