<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InventariosTable extends Component
{
   
    public $productosA;

    protected $listeners = [
        'refresh' => '$refresh',
        'data' => 'handleData',
    ];

    public function render()
    {
        return view('livewire.inventarios-table');
    }

    public function handleData($data)
    {
        $this->productosA = $data['productosA'];
        $this->emitSelf('refresh');
    }
}
