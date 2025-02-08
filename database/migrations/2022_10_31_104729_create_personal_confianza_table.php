<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalConfianzaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_confianza', function (Blueprint $table) {
            $table->id();
            $table->string('eid');
            $table->foreign('eid')->references('eid')->on('datosusers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('area');
            $table->foreign('area')->references('area_clave')->on('areas')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('personal_confianza');
    }
}
