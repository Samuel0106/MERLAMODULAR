<div>
    @if(@Auth::user()->hasRole('admin'))
        <?php $areaArray = array();
        foreach ($inventariosAutorizados as $areaInv) {
            if(!(in_array($areaInv->area,$areaArray))){
                $areaArray[] = $areaInv->area;
            }
        }
        ?>
        <p>Area:</p>
        <select name="selectArea" id="selectArea" class="w-50 p-2 mt-1 text-sm border-2 border-gray-200 rounded" wire:model="areaSeleccionada">
            <option value=''>Todos los pedidos</option>
            @foreach ($areaArray as $areaOpt)
                <option value={{ $areaOpt }}>{{ App\Models\Area::find($areaOpt)->area_nombre }}</option>
            @endforeach
        </select>
    @endif
    <table id="data-table" class="stripe hover translate-table"
        style="width:97%; padding-top: 1em;  padding-bottom: 1em;">
        <thead>
            <tr>
                <th>N.º PEDIDO</th>
                <th>eid</th>
                <th>NOMBRE</th>
                <th>EMAIL</th>
                <th>ALMACEN DE ORIGEN</th>
                <th>CENTRO DE DESTINO</th>
                <th>FECHA AUTORIZACIÓN</th>
                <th>STATUS</th>
                <th>ACCIONES</th>

            </tr>
        </thead>
        @can('inventario.entregar')
            <tbody>
                @foreach ($inventariosAutorizados as $inventario)
                    @if($areaSeleccionada == $inventario->area || $areaSeleccionada == '')
                        <tr data-id="{{ $inventario->id }}">
                            <td>{{ $inventario->id }}</td>
                            <td>{{ $inventario->eid }}</td>
                            <td>{{ $inventario->nombre }}</td>
                            <td>{{ $inventario->email }}</td>
                            <td>{{ App\Models\Subarea::find($inventario->almacen)->subarea_nombre }}</td>
                            <td>{{ App\Models\Subarea::find($inventario->subarea)->subarea_nombre }}</td>
                            <td>{{ $inventario->fecha_autorizado }}
                            <td>{{ $inventario->status }}</td>

                            <td>
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <a href="{{ route('inventarios.autorizarProductos', ['inventario' => $inventario->id]) }}"
                                        style="text-decoration:none;"
                                        class="rounded bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-auto">Entregar</a>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        @endcan
    </table>
</div>
