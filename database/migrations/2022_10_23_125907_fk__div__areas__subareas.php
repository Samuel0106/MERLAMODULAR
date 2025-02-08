<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FKDivAreasSubareas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('areas', function (Blueprint $table) {
            $table->foreign('division_id')
            ->references('division_clave')
            ->on('divisiones')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });

        Schema::table('subareas', function (Blueprint $table) {
            $table->foreign('area_id')
            ->references('area_clave')
            ->on('areas')
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
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign('areas_division_id_foreign');
        });

        Schema::table('subareas', function (Blueprint $table) {
            $table->dropForeign('subareas_area_id_foreign');

        });
    }
}
