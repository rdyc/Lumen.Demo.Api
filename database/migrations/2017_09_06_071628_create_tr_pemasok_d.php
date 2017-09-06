<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrPemasokD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_pemasok_d', function (Blueprint $table) {
            $table->uuid('pemasok_d_id');
            $table->uuid('pemasok_h_id');
            $table->bigInteger('element_id')->nullable();
            $table->bigInteger('parent_element')->nullable();
            $table->bigInteger('score')->nullable();
            $table->bigInteger('sorting');
            $table->bigInteger('sort_parent')->nullable();
            $table->bigInteger('target_element')->nullable();
            $table->bigInteger('group_element')->nullable();
            $table->string('field_name', 150);
            $table->string('field_type', 100)->nullable();
            $table->longText('val')->nullable();
            $table->string('url_lookup', 1000)->nullable();
            $table->string('url_data_api', 1000)->nullable();
            $table->string('kriteria', 250)->nullable();
            $table->string('session_data', 150)->nullable();
            $table->string('keterangan', 1000)->nullable();
            $table->string('latitude', 300)->nullable();
            $table->string('longitude', 300)->nullable();
            $table->string('special_form', 200)->nullable();
            $table->boolean('fl_lookup');
            $table->boolean('fl_target');
            $table->boolean('fl_multiple');
            $table->boolean('fl_group');
            $table->boolean('fl_end_group');
            $table->boolean('fl_max_score');
            $table->boolean('fl_lampiran');
            $table->boolean('fl_keterangan');
            $table->boolean('fl_additional_data');
            $table->boolean('fl_reference');
            $table->boolean('fl_end_level');
            $table->boolean('fl_status');
            $table->boolean('fl_koordinat');
            $table->boolean('fl_data_auth');
            $table->boolean('fl_data_api');
            $table->boolean('fl_lookup_data');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('pemasok_d_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_pemasok_d');
    }
}
