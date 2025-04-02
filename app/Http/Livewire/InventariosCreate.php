<?php

namespace App\Http\Livewire;

use App\Models\Almacen;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Producto;
use Livewire\Component;
use Auth;

class InventariosCreate extends Component
{
    public $almacenes;
    public $almacen;
    public $area;
    public $areas;
    public $areas1;
    public $subareas;
    public $subareas1;
    public $carro;
    public $productos;
    public $productosA;
    public $datos;
    public $user;
    public $subDestino;
    public $subareaAux;
    public $areaAux;
    public $areaSeleccionada;
    public $areaSeleccionada1;
    public $subareaSeleccionada;
    public $subareaSeleccionada1;
    public $inputBusqueda;
    public $porPagina = 10;
    public $cantidadBotones;
    public $paginaSeleccionada;
    public $idProductoUltimo = "";
    public $flagDatos = true;
    public $flagNuevaPagina = false;
    public $selectedPagination = 10;
    public $orders = [];
    public $tipoOrden;
    public $columnaSeleccionada;

    public function mount()
    {
        $this->idProductoUltimo = "";
        $this->inputBusqueda = "";
        $this->selectedPagination = 10;
        $this->flagNuevaPagina = false;
        $this->reiniciarOrden();
        $this->area = auth()->user()->datos->getArea->area_clave;
        $this->subarea = auth()->user()->datos->subarea;
        if ($this->carro->count() == 0) {
            $this->areas = Area::where([
                ['division_id', '=', 'DN'],
            ])->get();
            if(Auth::user()->hasRole('JefeInventario')){
                $this->areaSeleccionada = $this->areas->first()->area_clave;
            }else{
                $this->areaSeleccionada = $this->area;
            }
            $this->areas1 = Area::where([
                ['division_id', '=', 'DN'],
            ])->get();
            $this->areaSeleccionada1 = $this->area;
            $this->almacenes = Almacen::where('area_id', $this->areaSeleccionada)->where('habilitado',1)->get();
            $this->subareas1 = Subarea::where([
                ['area_id', '=', $this->areaSeleccionada1],
            ])->get();
            try {
                $this->almaceneseleccionado = $this->almacenes->first()->almacen_clave;
            } catch (\Throwable $th) {
                $this->almaceneseleccionado = null;
            }

            if ($this->almaceneseleccionado) {
                
                $subareaRelacionada = substr($this->almaceneseleccionado, 0, 2);
    
                $this->productosA = Producto::where('subarea', 'LIKE', $subareaRelacionada . '%')->get();
                
            } else {
                $this->productosA = collect();
            }
            $this->detectarCambio();
            $this->mostrarPaginado();
            try {
                $this->subareaSeleccionada1 = $this->subarea;
            } catch (\Throwable $th) {
                $this->subareaSeleccionada1 = null;
            }
            $this->subDestino = $this->subareaSeleccionada1;
        } else {
            $this->subareaSeleccionada1 = session()->get('subareaDestino');
            $this->almacen = Almacen::where('area_id', $this->areaSeleccionada1)->get()->first();
            $this->areas1 = Area::where([
                ['area_clave', '=', $this->areaSeleccionada1],
            ])->get();
            $this->subareas1 = Subarea::where([
                ['subarea_clave', '=', $this->subareaSeleccionada1],
            ])->get();
            $productos = Producto::all();
            foreach ($productos as $p) {
                if ($this->carro->where('id', $p->id)->count() > 0) {
                    $this->subareaAux = $p->almacenseleccionado;
                    $this->areaAux = $p->area;
                    break;
                }
            }
            if($this->subareaAux == null){
                $this->subareaAux = session()->get('almacenpe');
            }
            $this->almaceneseleccionado = session()->get('almacenpe');
            if($this->areaAux == null){
                $this->areaAux = $this->areaSeleccionada1;
            }
            /*
            $this->subareaAux = session()->get('almacen');      //
            if($this->subareaAux == null){                      //
                $this->subareaAux = session()->get('almacenpe');//
            };                                                  //
            $this->areaAux = $this->areaSeleccionada1;          //
            $this->almaceneseleccionado = $this->subareaAux;     //
            */
            
        if ($this->almaceneseleccionado) {
            
            $subareaRelacionada = substr($this->almaceneseleccionado, 0, 2);

            $this->productosA = Producto::where('subarea', 'LIKE', $subareaRelacionada . '%')->get();
        } else {
            $this->productosA = collect();
        }
            $this->detectarCambio();
            $this->mostrarPaginado();
            $this->subDestino = $this->subareaSeleccionada1;

        }
    }

    public function render()
    {
        $busqueda = $this->inputBusqueda;
    
        if (!$this->almaceneseleccionado) {
            $this->productosA = collect();
        } else {
            $subareaRelacionada = substr($this->almaceneseleccionado, 0, 2);

            $this->productosA = Producto::where('subarea', 'LIKE', $subareaRelacionada . '%')
                ->when($busqueda, function ($query) use ($busqueda) {
                    return $query->where('nombre_producto', 'LIKE', '%' . $busqueda . '%');
                })
                ->when($this->tipoOrden != 0, function ($query) {
                    return $query->orderBy($this->columnaSeleccionada, $this->tipoOrden);
                })
                ->get();
        }
    
        $this->detectarCambio();
        if ($this->flagNuevaPagina) {
            $this->asignarPaginacion();
            $this->flagNuevaPagina = false;
        }

        $this->mostrarPaginado();
        return view('livewire.inventarios-create');
    }
    
    public function reiniciarOrden()
    {
        $this->orders['nombre_producto'] = 0;
        $this->orders['id_categoria'] = 0;
        $this->orders['existencias'] = 0;
        $this->tipoOrden = 0;
        $this->columnaSeleccionada = 0;
    }
    public function ordenar($columna, $tipoOrden)
    {
        $this->reiniciarOrden();
        $this->columnaSeleccionada = $columna;
        if($tipoOrden == 0)
        {
            $this->orders[$columna] = 1;
            $this->tipoOrden = 'asc';
        }
        if($tipoOrden == 1)
        {
            $this->orders[$columna] = 2;
            $this->tipoOrden = 'desc';
        }
        if($tipoOrden == 2)
        {
            $this->orders[$columna] = 1;
            $this->tipoOrden = 'asc';
        }
    }
    public function detectarCambio()
    {
        if($this->productosA->count() == 0)
        {
            $this->idProductoUltimo = "";
            $this->cantidadBotones = 0;
            $this->paginaSeleccionada = 0;
        }
        else
        {
            if($this->idProductoUltimo != $this->productosA[0]->id)
            {
                $this->idProductoUltimo = $this->productosA[0]->id;
                $this->asignarPaginacion();
            }
        }
    }

    public function asignarPaginacion()
    {
        $numeroProductos = $this->productosA->count();
        $this->paginaSeleccionada = 1;
        $this->flagDatos = ($numeroProductos > 0) ? true : false;

        if($this->porPagina == 0)
        {
            $this->cantidadBotones = 0;
            $this->paginaSeleccionada = 0;
        }
        else
        {
            $this->cantidadBotones = ceil($numeroProductos / $this->porPagina);
        }
    }
    public function cambiarPaginado()
    {
        $this->porPagina = $this->selectedPagination;
        $this->flagNuevaPagina = true;  
    }

    public function mostrarPaginado()
    {
        if($this->porPagina != 0)
        {
            $cantidadASaltar = ($this->paginaSeleccionada * $this->porPagina)-$this->porPagina;
            $cantidadARetornar = $this->porPagina;
            $resultadosSaltados = $this->productosA->skip($cantidadASaltar);
            $resultadosTomados = $resultadosSaltados->take($cantidadARetornar);
            $this->productosA = $resultadosTomados;
        }
    }

    public function botonPaginadoSeleccionado($paginaNueva)
    {
        $this->paginaSeleccionada = $paginaNueva;
        $this->mostrarPaginado();
    }

    public function actualizarSubareas()
    {
        $area = Area::find($this->areaSeleccionada);
        $this->almacenes = Almacen::where('area_id', $area->area_clave)->where('habilitado',1)->get();
        try {
            $this->almaceneseleccionado = $this->almacenes->first()->almacen_clave;
        } catch (\Throwable $th) {
            $this->almaceneseleccionado = null;
        }
        
        $this->productosA = Producto::where([
            ['subarea', '=', $this->almaceneseleccionado],
        ])->get();
    }
    public function actualizarSubareas1()
    {
        $area1 = Area::find($this->areaSeleccionada1);
        $this->subareas1 = Subarea::where([
            ['area_id', '=', $area1->area_clave],
        ])->get();
        try {
            $this->subareaSeleccionada1 = $this->subareas1->first()->subarea_clave;
        } catch (\Throwable $th) {
            $this->subareaSeleccionada1 = null;
        }
        $this->subDestino = $this->subareaSeleccionada1;
        $this->reiniciarOrden();
    }
    public function actualizarProductos()
    {
        if (!$this->almaceneseleccionado) {
            $this->productosA = collect();
            return;
        }
        $subareaRelacionada = substr($this->almaceneseleccionado, 0, 2);
        
        $this->productosA = Producto::where('subarea', 'LIKE', $subareaRelacionada . '%')->get();
        
    }
    public function cambioSubDestino()
    {
        $this->subDestino = $this->subareaSeleccionada1;
        $this->reiniciarOrden();
    }
}
