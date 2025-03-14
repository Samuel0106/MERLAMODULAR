<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Datosuser;

class DatosuserSeederPrueba extends Seeder {
    /**
     *Runthedatabaseseeds.
     *
     *@returnvoid
     */
    public function run() {

    //Datosuser::create(['eid'=>'P0606', 'nombre'=>'Samuel', 'paterno'=>'Usuario', 'materno'=>'Personal','puesto'=>'SECRETARIO DE TRABAJO','area'=>'DX12','subarea'=>'DX12X','division'=>'DX']);
    //Datosuser::create(['eid'=>'ARH06', 'nombre'=>'Samuel', 'paterno'=>'Jefe', 'materno'=>'ARH','puesto'=>'SECRETARIO DE TRABAJO','area'=>'DX11','subarea'=>'DX11X','division'=>'DX']);
    Datosuser::create(['eid'=>'ADM06', 'nombre'=>'Samuel', 'paterno'=>'Admin', 'materno'=>'Admin','contrato'=> '1', 'puesto'=>'1','area'=>'DN0','subarea'=>'DN00','division'=>'DN']);

        //DB::statement("UPDATE datosusers SET antiguedad = '1995-07-24' WHERE RPE= 'P0606';");
//DB::statement("UPDATE datosusers SET antiguedad = '1996-01-09' WHERE RPE= 'ARH06';");
DB::statement("UPDATE datosusers SET antiguedad = '1996-06-07' WHERE eid= 'ADM06';");

    }
}
