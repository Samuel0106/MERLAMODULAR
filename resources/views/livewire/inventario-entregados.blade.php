<div>

    @if(@Auth::user()->hasRole('admin'))
        <?php $areaArray = array();
        foreach ($inventariosEntregados as $areaInv) {
            if(!(in_array($areaInv->area,$areaArray))){
                $areaArray[] = $areaInv->area;
            }
        }
        ?>
        <p>Area:</p>
        <select id="selectArea" class="w-100 p-2 mt-1 text-sm border-2 border-gray-200 rounded" wire:model="areaSeleccionada">
            <option value="ALL">Todas las entregas</option>
            <option value=''>Ninguna de las entregas</option>
            @foreach ($areaArray as $areaOpt)
                <option value={{ $areaOpt }}>{{ App\Models\Area::find($areaOpt)->area_nombre }}</option>
            @endforeach
        </select>
    @endif

    <table id="data-table" class="stripe hover translate-table"
    style="width:98%; padding-top: 1em;  padding-bottom: 1em;">

    <thead>
        <tr>
            <th>N.° PEDIDO</th>
            <th>ALMACEN DE ORIGEN</th>
            <th>CENTRO DE DESTINO</th>
            <th>PERSONA DE DESTINO</th>
            <th>FECHA CREACIÓN</th>
            <th>FECHA AUTORIZACIÓN</th>
            <th>FECHA ENTREGA</th>
            <th>STATUS</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventariosEntregados as $inventario)
                <tr data-id="{{ $inventario->id }}">
                    <td>{{ $inventario->id }}</td>
                    <td>{{ App\Models\Subarea::find($inventario->almacen)->subarea_nombre }}</td>
                    <td>{{ App\Models\Subarea::find($inventario->subarea)->subarea_nombre }}</td>
                    <?php
                    $user = App\Models\Datosuser::whereeid($inventario->eid)->first();                                    if($user != null){
                        $nombre = $user->paterno . " " . $user->materno . ", " . $user->nombre;
                    }
                    else{
                        $nombre = "Desconocido - ". $inventario->eid;
                    }
                    ?>
                    <td class="uppercase">{{$nombre}}</td>
                    <td>{{ $inventario->created_at->format('Y-m-d')}}</td>
                    <td>{{ $inventario->fecha_autorizado}}</td>
                    <td>{{ $inventario->fecha_entrega}}</td>
                    <td>{{ $inventario->status }}</td>

                    <td class=" px-4 py-2">
                        <div class="flex justify-center rounded-lg text-lg" role="group">
                            <!-- botón Ver -->
                            <a href="{{ route('inventarios.show', $inventario->id) }}"
                                style="text-decoration: none"
                                class="rounded bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 mx-auto mr-2">Ver</a>
                            <!-- botón borrar -->
                            @if ($inventario->status == 'Pendiente')
                            <form action="{{ route('inventarios.destroy', $inventario->id) }}"
                                id="formEliminar{{ $inventario->id }}" method="POST"
                                class="formEliminar mx-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 mx-auto">Borrar</button>
                            </form>                         
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
</div>

<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";

    $(function(){
        $('selectArea').on('change',function(){
            var f_area = document.getElementById("selectArea").value;
            var table = $('#data-table').DataTable();
                table.clear();
            fetch(SITEURL + '/actualizar',{
                method : 'POST',
                body: JSON.stringify({area: f_area, "_token": "{{ csrf_token() }}" }),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                },
            }).then(response =>{
                return response.json()
            }).then( data =>{
                var estatus = "";
                var acciones = "";
                table.clear();

                if(data.lista.length != 0){
                    for (let i in data.lista) {

                        table.row.add([
                            data.lista[i].id,
                            data.lista[i].almacen,
                            data.lista[i].subarea,
                            data.lista[i].eid,
                            moment(data.lista[i].created_at).format('DD-MM-YYYY'),
                            data.lista[i].fecha_autorizacion,
                            data.lista[i].fecha_entrega,
                            status,
                            acciones
                        ]);
                    }
                }


                table.draw();
            }).catch(error =>alert(error));
        })
    });
</script>
