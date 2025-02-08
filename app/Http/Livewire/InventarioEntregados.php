<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InventarioEntregados extends Component
{
    public $inventariosEntregados;
    public $areaSeleccionada;

    public function mount(){
        $areaSeleccionada = '';
    }

    public function render()
    {
        return view('livewire.inventario-entregados');
    }
}
