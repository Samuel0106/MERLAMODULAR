<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Almacen;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProductoCrear extends Component
{
    public $categorias; 
    public $almacen;
    Public $area;
    public $areaSeleccionada;
    public $almacenes;
    public function render()
    {
        return view('livewire.producto-crear');
    }

    public function mount()
    {
        if(Auth::user()->can('producto.todosalmacenes'))
            $this->almacenes = Almacen::where('habilitado',1)->get();
        else
            $this->almacenes = Almacen::where('jefe_eid', Auth::user()->eid)->where('habilitado',1)->get();
    }
}
