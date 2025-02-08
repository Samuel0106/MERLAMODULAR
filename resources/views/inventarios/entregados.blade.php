<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedidos entregados') }}
        </h2>
    </x-slot>


    @section('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            @if (session()->has('message'))
                <div class="px-2 inline-flex flex-row" id="mssg-status">
                    {{ session()->get('message') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @elseif(session()->has('error'))
                <div class="px-2 inline-flex flex-row py-1 text-black" id="mssg-status">
                    {{ session()->get('error') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <div class="my-4 px-3 py-3 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ route('inventarios.inicio') }}"
                            class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            Regresar
                        </a>
                    </div>
                </div>
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
                        <select id="selectArea" 
                        class="grid grid-cols-1 mt-1 rounded-lg border-2 border-blue-600 block focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="ALL">Todas las entregas</option>
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
                                    @if(App\Models\Almacen::find($inventario->almacen))
                                    <td>{{ App\Models\Almacen::find($inventario->almacen)->almacen_nombre }}</td>
                                    @else
                                        <td>{{ App\Models\Subarea::find($inventario->almacen)->subarea_nombre }}</td>
                                    @endif

                                    @if(App\Models\Subarea::find($inventario->subarea))
                                        <td>{{ App\Models\Subarea::find($inventario->subarea)->subarea_nombre }}</td>
                                    @else
                                        <td>{{ App\Models\Almacen::find($inventario->subarea)->almacen_nombre }}</td>
                                    @endif
                                    <?php
                                    $user = App\Models\Datosuser::whereeid($inventario->eid)->first();
                                    if($user != null){
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
            </div>
        </div>
        @section('js')
            <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js">
            </script>
            <script>
                $(document).ready(function() {
                    $('#data-table').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json'
                        }
                    });
                });
            </script>
            <script>
                const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
                var SITEURL = "{{ url('/') }}";
            
                $(function(){
                    $('#selectArea').on('change',function(){
                        var f_area = document.getElementById("selectArea").value;
                        var f_status = "Entregado";
                        var table = $('#data-table').DataTable();
                        table.clear();

                        fetch( SITEURL + '/actualizar',{
                            method : 'POST',
                            body: JSON.stringify({area: f_area,status:f_status, "_token": "{{ csrf_token() }}" }),
                            headers:{
                                'Content-Type': 'application/json',
                                "X-CSRF-Token": csrfToken
                            },
                        }).then( response =>{
                            return response.json()
                        }).then( data =>{
                            table.clear();

                            if(data.lista.length != 0){
                                for (let i in data.lista) {
                                    var url = "{{ App\Models\Subarea::find('":id"')}}";
                                    url = url.replace(':id',"DX177");

                                    var url_ver = '{{ route('inventarios.show', ':id') }}';
                                    url_ver = url_ver.replace(':id', data.lista[i].id);

                                    subarea = "<div> ";
                                    subarea += url;
                                    subarea += " </div>";
                                    // alert(subarea);
                                    almacen = "<div> {{ App\Models\Subarea::find('DX177') }} </div>";

                                    acciones = "<td class=' px-4 py-2'>";
                                    acciones += "<div class='flex justify-center rounded-lg text-lg' role='group'>";

                                    acciones += "<a href='" + url_ver + "'" +
                                                "style='text-decoration: none'"+
                                                "class='rounded bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 mx-auto mr-2'>Ver</a>";   

                                    acciones += "</div>";
                                    acciones += "</td>";
                                    table.row.add([
                                        data.lista[i].id,
                                        data.lista[i].almacen_nombre,
                                        data.lista[i].subarea_nombre,
                                        data.lista[i].nombre.toUpperCase(),
                                        data.lista[i].created_at.substr(0,10),
                                        data.lista[i].fecha_autorizado,
                                        data.lista[i].fecha_entrega,
                                        data.lista[i].status,
                                        acciones
                                    ]);
                                }
                            }
            
                            table.draw();
                        }).catch(error =>alert(error));

                    });
                });
            </script>
        @endsection
</x-app-layout>

