<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FKResguardosCreated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('divisiones', function (Blueprint $table) {
            $table->string('division_clave')->unique()->change();
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->string('area_clave')->unique()->change();
        });

        Schema::table('subareas', function (Blueprint $table) {
            $table->string('subarea_clave')->unique()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('divisiones', function (Blueprint $table) {
            $table->string('division_clave')->change();
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->string('area_clave')->change();
        });

        Schema::table('subareas', function (Blueprint $table) {
            $table->string('subarea_clave')->change();
        });

    }
}
