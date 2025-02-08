<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use App\Models\Producto;


class InventarioIndex extends Component
{
    public $categorias;
    public $categoriasT;
    public $categoriaSelect;
    public $productos;
    public $productosT;

    public function mount()
    {
        $this->categorias = Categoria::get();
        $this->productosT = $this->productos;
    }

    public function render()
    {
        return view('livewire.inventario-index');
    }
    
    public function actualizarDatos()
    {
        
        if($this->categoriaSelect != 0)
        {
            $this->productosT = Producto::where([
                ['categoria_id', '=', $this->categoriaSelect],
                ])->get();
            }
            else{
                $this->productosT = Producto::all();
            }
    }
}
