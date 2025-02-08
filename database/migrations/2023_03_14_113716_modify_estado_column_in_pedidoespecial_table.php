<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEstadoColumnInPedidoespecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidoespecial', function (Blueprint $table) {
            $table->string('estado')->default('Pendiente')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidoespecial', function (Blueprint $table) {
            $table->string('estado')->change();
        });
    }
}
