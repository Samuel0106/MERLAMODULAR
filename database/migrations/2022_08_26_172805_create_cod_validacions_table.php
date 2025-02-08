<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodValidacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_validacions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();   //Código de verificación enviado al correo
            $table->string('correo')->nullable();   //¿Se necesita guardar el correo al que se le envió el código?
            $table->string('foto')->nullable(); //Foto de entrega del inventario.
            $table->integer('folio')->nullable(); //id del inventario que se esta entregando.
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
        Schema::dropIfExists('cod_validacions');
    }
}
