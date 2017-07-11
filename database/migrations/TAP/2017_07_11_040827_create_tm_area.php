<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_area', function (Blueprint $table) {
            $table->increments('area_id');
            $table->string('kode_area', 75);
            $table->string('nama_area', 200);
            $table->string('region', 200);
            $table->string('perusahaan', 200);
            $table->string('kode_area_sap', 75);
            $table->string('kode_group_area', 75);
            $table->boolean('fl_status');
            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->string('deleted_by', 150)->nullable();
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
        Schema::dropIfExists('tm_area');
    }
}
