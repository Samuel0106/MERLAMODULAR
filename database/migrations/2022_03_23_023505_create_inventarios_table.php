<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('eid',5);
            $table->string('nombre');
            $table->string('email');
            $table->string('area');
            $table->string('almacen',5);
            $table->string('subarea',5);
            $table->string('status',25);
            $table->string('comentario')->nullable();
            $table->json('carrito');
            $table->boolean('oculto');
            $table->boolean('proposito')->default(0);
            $table->date('fecha_entrega')->nullable();
            $table->date('fecha_autorizado')->nullable();
            $table->string('foto_entrega');
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
        Schema::dropIfExists('inventarios');
    }
}
