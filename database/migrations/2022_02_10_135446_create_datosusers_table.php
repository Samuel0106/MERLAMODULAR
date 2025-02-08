<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datosusers', function (Blueprint $table) {
            $table->id();
            $table->string('eid',5)->unique();
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno');
            $table->date('ingreso')->nullable();
            $table->date('antiguedad')->nullable();
            $table->string('contrato')->nullable();
            $table->string('puesto')->nullable();
            $table->string('area')->nullable()->default(null);
            $table->string('subarea');
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
        Schema::dropIfExists('datosusers');
    }
}
