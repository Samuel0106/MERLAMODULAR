<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_producto');
            $table->string('unidad');
            $table->integer('stock_minimo');
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id')->on('categorias')->onUpdate('cascade');
            $table->string('area');
            $table->string('subarea');
            $table->integer('existencias');
            $table->string('photo_prod')->nullable();
            $table->timestamps();
        });
        
        // Schema::table('productos', function($table) {
        //     $table->foreign('categoria')->references('nombre_categoria')->on('categorias')->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
