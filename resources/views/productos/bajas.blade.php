<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestionar Existencias ')}}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="mt-4 px-4 py-3 ml-3 leading-normal text-green-500 rounded-lg" role="alert">
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
        @if (\Session::has('error'))
            <div class="px-2 inline-flex flex-row ml-5 mt-20 mb-3">
                {!! \Session::get('error') !!}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>

            </div>
        @endif
    {{-- Select filtro por categorias --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-5 md:gap-8 mt-5 mx-7">
        <div class="grid grid-cols-1">
            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Categoria:</label>
            <select id="_categoria_filtro" name="categoria_filtro" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre_categoria }}</option>
                @endforeach
                <option value="0" style='color: blue;'>Todas</option>
            </select>
        </div>
    </div>
    {{-- Boton filtro por categorias --}}
    <div class="grid grid-rows-1 place-items-center mt-3 mb-3">
        <!-- botón Filtrar -->
        <button onClick="getParameters()" style="text-decoration:none;"
            class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
    </div>
    <div class="col-sm-12">
        @if($mensaje = Session::get('success'))
            <div class="alert alert-success" role="alert">
            {{ $mensaje }}
            </div>
        @endif
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6"
        style="width:95%; margin-bottom: 5em; margin-right:auto; margin-left:auto ">
        
        <table id="data-table" class="stripe hover translate-table"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-white">
                <tr class="bg-gray-800 text-white">
                    <th>ID</th>
                    <th>NOMBRE DEL PRODUCTO</th>
                    <th>TIPO DE UNIDAD</th>
                    <th>STOCK MÍNIMO</th>
                    <th>CATEGORÍA</th>
                    <th>CANTIDAD SOLICITADA</th>
                    <th>EXISTENCIAS</th>
                    <th>ALMACÉN</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($productos as $producto)
                    <tr data-id="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre_producto }}</td>
                        <td>{{ $producto->unidad }}</td>
                        <td>{{ $producto->stock_minimo }}</td>
                        <td>{{ $producto->categoria->nombre_categoria }}</td>
                        <td>{{ $producto->solicitados_cant }}</td>
                        <td>{{ $producto->existencias }}</td>
                        @if($producto->subareas)
                            {{-- @dd($producto) --}}
                            <td>{{ $producto->areas->area_nombre }} , {{ $producto->subareas->subarea_nombre }}</td>
                        @elseif($producto->almacenes)
                            <td>{{ $producto->areas->area_nombre }} , {{ $producto->almacenes->almacen_nombre }}</td>
                        @else
                            <td>Unknow</td>
                        @endif
                        <td class="px-14 py-1">
                            @if ($producto->photo_prod != null)
                                <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} " width="50ppx"
                                    id="imagenSeleccionada" alt="Foto actual del producto">
                            @else
                                <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                    width="50ppx" id="imagenSeleccionada"
                                    alt="Foto actual del producto">
                            @endif
                            
                            
                        </td>

                        <td class="border-l px-4 py-2">
                            <div class="flex justify-center rounded-lg text-sm" role="group">
                                <!-- botón añadir existencias -->
                                <a href="{{ route('productos.editI', $producto->id) }}" style="text-decoration:none;"
                                    class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mx-2 ml-2">Agregar</a>
                                <!-- botón añadir mermas -->
                                    <a href="{{ route('mermas.anadirMermas', $producto->id) }}" style="text-decoration:none;"
                                    class="rounded bg-blue-600 hover:bg-green-700 text-white font-bold py-2 px-4 mx-2 ml-1 transition-colors">Merma</a>   
                                <!-- botón eliminar existencias -->
                                    <a href="{{ route('productos.eliminarExistenciasProducto', $producto->id) }}" style="text-decoration:none;"
                                    class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 ml-1">Quitar por Consumo</a>
                                <!-- botón historial -->
                                <a href="{{ route('bajas.show', $producto->id) }}" style="text-decoration:none;"
                                    class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 mx-2">Historial</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js')}}"></script>
    @endsection
</x-app-layout>

<script>    
    function getParameters(){

        $(document).ready(function(e) {
        $('#imagenSeleccionada').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });

        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        var SITEURL = "{{ url('/') }}";
        var f_categoria = document.getElementById("_categoria_filtro").value;
        var table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtroQuitarExistencias',{
            method : 'POST',
            body: JSON.stringify({categoria: f_categoria, "_token": "{{ csrf_token() }}"}),
            headers:{
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response =>{
            return response.json()
        }).then( data =>{
            var acciones = "";
            var foto = "";
            var almacen = "";
            table.clear();
            if(data.lista != null && data.lista.length != 0){
                for (let i in data.lista) {

                    var url_editI = '{{ route('productos.editI', ':id') }}';
                    url_editI = url_editI.replace(':id', data.lista[i].id);

                    var url_merma = '{{ route('mermas.anadirMermas', ':id') }}';
                    url_merma = url_merma.replace(':id', data.lista[i].id);

                    var url_quitar_por_consumo = '{{ route('productos.eliminarExistenciasProducto', ':id') }}';
                    url_quitar_por_consumo = url_quitar_por_consumo.replace(':id', data.lista[i].id);
                    
                    var url_show_bajas = '{{ route('bajas.show', ':id') }}';
                    url_show_bajas = url_show_bajas.replace(':id', data.lista[i].id);

                    var url_foto = '{{ asset('imagen_productos/'. ':photo_prod') }}';
                    url_foto = url_foto.replace(':photo_prod', data.lista[i].photo_prod);

                    acciones = "<td class='border-l px-4 py-2'>"+
                                    "<div class='flex justify-center rounded-lg text-lg' role='group'>" +
                                        "<a href='" + url_editI + "'" +
                                        "style='text-decoration:none;'" +
                                        "class='rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mx-2 ml-2'>Agregar</a> "+

                                        "<a href='" + url_merma + "'" +
                                        "style='text-decoration:none;'" + 
                                        "class='rounded bg-blue-600 hover:bg-green-700 text-white font-bold py-2 px-4 mx-2 ml-1 transition-colors'>Merma</a>" +
                                        
                                        "<a href='" + url_quitar_por_consumo + "'" +
                                        "style='text-decoration:none;'" + 
                                        "class='rounded bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 ml-1'>Quitar por Consumo</a>" +
                                        
                                        "<a href='" + url_show_bajas + "'" +
                                        "style='text-decoration:none;'" + 
                                        "class='rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 mx-2'>Historial</a>" +
                                    "</div>"+
                                "</td>";

                    foto = "<td class='px-14 py-1'>"+
                            "<img src= '" + url_foto + "'" +
                            " width='50ppx' "+
                                "id='imagenSeleccionada' alt='Foto actual del producto'>"+
                            "</td>";

                    almacen = data.lista[i].areas.area_nombre + ", ";
                    if(data.lista[i].subareas){
                        almacen += data.lista[i].subareas.subarea_nombre;
                    }
                    else if(data.lista[i].almacenes){
                        almacen += data.lista[i].almacenes.almacen_nombre;
                    }
                    else{
                        almacen += "Unkwnow";
                    }

                    table.row.add([
                        data.lista[i].id,
                        data.lista[i].nombre_producto,
                        data.lista[i].unidad,
                        data.lista[i].stock_minimo,
                        data.lista[i].categoria.nombre_categoria,
                        data.lista[i].solicitados_cant,
                        data.lista[i].existencias,
                        almacen,
                        foto,
                        acciones
                    ]);
                }
            }
            table.draw();
        }).catch(error =>alert(error));
    }
</script>
