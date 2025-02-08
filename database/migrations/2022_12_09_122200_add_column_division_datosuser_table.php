<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDivisionDatosuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datosusers', function (Blueprint $table) {
            $table->string('division')->nullable();
            $table->foreign('division')
            ->references('division_clave')
            ->on('divisiones')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datosusers', function (Blueprint $table) {
            $table->dropForeign('datosusers_division_foreign');
            $table->dropColumn('division');
        });
    }
}
