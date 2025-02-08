<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class CentrosTrabajo extends Component
{
    public $divisiones;
    public $areas;
    public $subareas;
    public $divSelect;
    public $areaSelect;

    public function mount(){
        $this->divisiones = DB::table('divisiones')->get();
        $this->areas = DB::table('areas')->get();
        $this->subareas = DB::table('subareas')->get();
        $this->divSelect = $this->divisiones[0]->division_clave;
    }

    public function render()
    {
        $this->areas = DB::table('areas')->where('division_id',$this->divSelect)->get();
        return view('livewire.centros-trabajo');
    }
}
