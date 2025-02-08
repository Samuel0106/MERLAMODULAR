<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personales', function (Blueprint $table) {
            $table->id();
            $table->string('eid');
            $table->string('cirugia');
            $table->integer('vacuna');
            $table->date('fecha');
            $table->integer('inmunizaciones');
            $table->string('herencia');
            $table->string('area');
            $table->string('subarea');
            $table->string('tabaquismo');
            $table->string('alcholismo');
            $table->string('toxicomanias');
            $table->string('par_sexuales');
            $table->string('menarca');
            $table->integer('fum');
            $table->integer('para');
            $table->integer('aborto');
            $table->integer('cesaria');
            $table->string('ets');
            $table->string('anticonceptivos');
            $table->date('pap');
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
        Schema::dropIfExists('personales');
    }
}
