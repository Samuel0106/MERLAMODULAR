<?php

namespace App\Http\Livewire;

use App\Models\Almacen;
use App\Models\Producto;
use Livewire\Component;
use Auth;

class FiltroProductos extends Component
{
    public $productos;
    public $productosC;
    public $categorias;
    public $categoria;
    public $categoriaSeleccionada;

    public function render()
    {
        return view('livewire.filtro-productos');
    }

    public function mount()
    {
        if (Auth::user()->hasRole('admin')) {
            $this->productosAlmacen = Producto::all();
        } else {
            $this->almacen = Almacen::where('jefe_eid', auth()->user()->datos->eid)->where('habilitado', 1)->get();
            $this->productosAlmacen = Producto::where('subarea', $this->almacen[0]->almacen_clave)->get();
            for ($i = 1; $i < $this->almacen->count(); $i++) {
                $prod = Producto::where('subarea', $this->almacen[$i]->almacen_clave)->get();
                $this->productosAlmacen = $this->productosAlmacen->merge($prod);
            }
        }
    }
    // public function cambioCategoria()
    // {
    //     if ($this->categoriaSeleccionada != '0') {
    //         $this->productosAlmacen = Producto::where('subarea', $this->almacen[0]->almacen_clave)
    //             ->where('id_categoria', $this->categoriaSeleccionada)->get();
    //         for ($i = 1; $i < $this->almacen->count(); $i++) {
    //             $prod = Producto::where('subarea', $this->almacen[$i]->almacen_clave)->get();
    //             $this->productosAlmacen = $this->productosAlmacen->merge($prod);
    //         }
    //     } else {
    //         $this->productosAlmacen = Producto::where('subarea', $this->almacen[0]->almacen_clave)->get();
    //         for ($i = 1; $i < $this->almacen->count(); $i++) {
    //             $prod = Producto::where('subarea', $this->almacen[$i]->almacen_clave)->get();
    //             $this->productosAlmacen = $this->productosAlmacen->merge($prod);
    //         }
    //     }
    // }
}
