<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InventarioEntregar extends Component
{
    public $inventariosAutorizados;
    public $areaSeleccionada;

    public function mount(){
        $areaSeleccionada = '';
    }

    public function render()
    {
        return view('livewire.inventario-entregar');
    }
}
