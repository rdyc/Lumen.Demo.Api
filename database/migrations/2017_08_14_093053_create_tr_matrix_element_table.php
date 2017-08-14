<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrMatrixElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_matrix_element', function (Blueprint $table) {
            $table->increments('matrix_element_id');
            $table->integer('element_id');
            $table->string('kategori', 225);
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
        Schema::dropIfExists('tr_matrix_element');
    }
}
