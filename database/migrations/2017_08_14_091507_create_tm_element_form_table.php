<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmElementFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_element_form', function (Blueprint $table) {
            $table->increments('element_id');
            $table->integer('parent_element')->nullable();
            $table->string('field_name', 150)->nullable();
            $table->string('field_type', 100)->nullable();
            $table->string('special_form', 200)->nullable();
            $table->string('kriteria', 250)->nullable();
            $table->integer('score')->nullable();
            $table->integer('sorting')->nullable();
            $table->integer('sort_parent')->nullable();
            $table->integer('group_element')->nullable();
            $table->integer('target_element')->nullable();
            $table->string('session_data', 150)->nullable();
            $table->string('url_lookup', 1000)->nullable();
            $table->string('url_data_api', 1000)->nullable();
            $table->boolean('fl_lookup');
            $table->boolean('fl_lookup_data');
            $table->boolean('fl_target');
            $table->boolean('fl_multiple');
            $table->boolean('fl_group');
            $table->boolean('fl_end_group');
            $table->boolean('fl_lampiran');
            $table->boolean('fl_keterangan');
            $table->boolean('fl_additional_data');
            $table->boolean('fl_reference');
            $table->boolean('fl_end_level');
            $table->boolean('fl_status');
            $table->boolean('fl_max_score');
            $table->boolean('fl_koordinat');
            $table->boolean('fl_data_auth');
            $table->boolean('fl_data_api');
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
        Schema::dropIfExists('tm_element_form');
    }
}
