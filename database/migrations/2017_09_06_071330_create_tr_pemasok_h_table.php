<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrPemasokHTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_pemasok_h', function (Blueprint $table) {
            $table->uuid('pemasok_h_id');
            $table->string('kode_pemasok', 15);
            $table->string('nama_pemasok', 150);
            $table->string('kategori_pemasok', 100);
            $table->string('area_code', 200)->nullable();
            $table->string('no_ktp', 20)->nullable();
            $table->bigInteger('area_id')->nullable();
            $table->string('device', 100)->nullable();
            $table->string('sync_version', 75)->nullable();
            $table->boolean('fl_status');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('pemasok_h_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_pemasok_h');
    }
}
