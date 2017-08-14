<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrRulesValidasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_rules_validasi', function (Blueprint $table) {
            $table->increments('rules_validasi_id');
            $table->integer('element_id');
            $table->integer('min_length');
            $table->integer('max_length');
            $table->boolean('fl_readonly');
            $table->boolean('fl_display_month');
            $table->boolean('fl_display_year');
            $table->boolean('fl_related_validasi');
            $table->boolean('fl_reusable');
            $table->boolean('fl_require');
            $table->boolean('fl_status');
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
        Schema::dropIfExists('tr_rules_validasi');
    }
}
