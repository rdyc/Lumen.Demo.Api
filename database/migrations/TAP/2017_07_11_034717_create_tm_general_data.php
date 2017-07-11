<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmGeneralData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_general_data', function (Blueprint $table) {
            $table->string('general_code', 225);
            $table->string('description_code', 225)->nullable();
            $table->string('description', 1000)->nullable();
            $table->binary('icon')->nullable();
            $table->integer('sorting')->nullable();
            $table->boolean('fl_status');
            $table->string('created_by', 150)->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->string('deleted_by', 150)->nullable();
            $table->timestamps();
            $table->primary('general_code');
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
        Schema::dropIfExists('tm_general_data');
    }
}
