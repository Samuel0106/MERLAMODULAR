<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Almacen;
use Livewire\Component;
use App\Models\Datosuser;

class Almacenes extends Component
{

    public $almacenes;
    public $actuales = [];
    public $selectedArea;
    public $areas;
    
    public function mount(){
        $this->areas = Area::where('division_id','DN')->get();
        $this->selectedArea = $this->areas->first()->area_clave;
    }
    public function render()
    {
        $this->almacenes = Almacen::where('area_id',$this->selectedArea)->get();
        return view('livewire.almacenes');
    }
    public function update($id){
        $almacen = Almacen::where('id',$id)->get()->first();
        if($almacen->habilitado)
        {
            $almacen->habilitado = 0;
        }
        else{
            $almacen->habilitado = 1;  
        }
        $almacen->save();
    }

    // Esta función actualiza el eid del jefe de un almacén específico
    public function actualizarJefeeid($nvo , $clav)
    {
        $eid = $nvo;
        $clave = $clav;
        $almacen = Almacen::where('almacen_clave', $clave)->first();
        $almacen->jefe_eid = $eid;
        $almacen->save();
    }

    // Esta función devuelve true y el usuario si un usuario con el eid dado existe en la tabla datosusers, false en caso contrario
    public function usuarioExiste($eid) {
        return Datosuser::where('eid', $eid)->first();
    }

    // Esta función devuelve la instancia de la tabla Area cuyo campo area_clave coincide con el valor de $almacen
    public function returnArea($almacen)
    {
        return Area::where('area_clave', $almacen)->first();
    }

}
