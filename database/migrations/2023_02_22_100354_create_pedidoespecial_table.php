<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoespecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidoespecial', function (Blueprint $table) {
            $table->id();
            $table->string('solicitante');
            $table->string('responsable');
            $table->string('nombre_prod');
            $table->integer('cantidad');
            $table->string('descripcion');
            $table->string('foto');
            $table->string('justificacion');
            $table->string('estado');
            $table->integer('import');
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
        Schema::dropIfExists('pedidoespecial');
    }
}
