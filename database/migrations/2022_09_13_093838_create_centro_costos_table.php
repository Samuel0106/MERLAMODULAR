<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentroCostosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('centro_costos', function (Blueprint $table) {
            $table->id();
            $table->string('division_clave');
            $table->string('area_sap');
            $table->string('proceso');
            $table->string('ceco_clave');
            $table->string('ceco_descripcion');
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
        Schema::dropIfExists('centro_costos');
    }
}
