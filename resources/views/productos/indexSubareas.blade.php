<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Productos - 
            {{ __($area->first()->area_nombre) }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="mt-4 px-4 py-3 ml-11 leading-normal text-green-500 rounded-lg" role="alert">
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
    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">
        <div class="grid grid-cols-2 hidden">
            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
            <select id="_area_filtro" name="area_filtro"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="{{ $area->first()->area_clave }}">
                    {{ $area->first()->area_nombre }}</option>

            </select>
        </div>
        <div class="grid grid-cols-1 ">
            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Subárea:</label>
            <select id="_subarea_filtro" name="subarea_filtro"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="0" style='color: blue;'>Todas</option>
                @foreach ($subareas as $subarea)
                    <option <?php if ($subarea->subarea_clave == $subareas[0]->subarea_clave) {
                        print 'selected';
                    } ?> value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1">
            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Categoria:</label>
            <select id="_categoria_filtro" name="categoria_filtro"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="0" style='color: blue;'>Todas</option>

                @foreach ($categorias as $cat)
                    <option <?php if ($cat->id == $categorias[0]->id) {
                        print 'selected';
                    } ?> value="{{ $cat->id }}">{{ $cat->nombre_cat }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    <div class="grid grid-rows-1 place-items-center mt-3">
        <!-- botón Filtrar -->
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        <button onClick="getParameters()" style="text-decoration:none;"
            class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
    </div>
    <div class="col-sm-12">
        @if ($mensaje = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $mensaje }}
            </div>
        @endif
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6"
        style="width:95%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto ">

        <table id="data-table" class="stripe hover translate-table"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-white">
                <tr class="bg-gray-800 text-white">
                    <th>ID</th>
                    <th>NOMBRE DEL PRODUCTO</th>
                    <th>TIPO DE UNIDAD</th>
                    <th>STOCK MÍNIMO</th>
                    <th>CATEGORÍA</th>
                    <th>EXISTENCIAS</th>
                    <th>ALMACEN</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($productos as $producto)
                    <tr data-id="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre_prod }}</td>
                        <td>{{ $producto->unidad }}</td>
                        <td>{{ $producto->stock_min }}</td>
                        <td>{{ $producto->categoria->nombre_cat }}</td>
                        <td>{{ $producto->existencias }}</td>
                        @if ($producto->subareas)
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

                        @can('producto.crear')
                            <td class="border-l px-4 py-2">
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <!-- botón editar -->
                                    <a href="{{ route('productos.edit', $producto->id) }}" style="text-decoration:none;"
                                        class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 mx-2 ml-2">Editar</a>

                                    <!-- botón borrar -->
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                        class="rounded formEliminar bg-red-600 hover:bg-red-700 ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded text-white font-bold py-2 px-2 mx-2 ml-2">Borrar</button>
                                    </form>
                                </div>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div class="grid place-content-end mt-5 mb-3">
            <a type="button" href="{{ route('productos.create') }}"
                class="bg-blue-600 px-12 py-2 rounded text-white font-semibold hover:bg-blue-700 transition duration-200 each-in-out">
                Crear</a>
        </div>
    </div>
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script src="{{ 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js' }}"></script>
    @endsection
</x-app-layout>

<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la eliminación del registro?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Eliminado!',
                                'El registro ha sido eliminado exitosamente.', 'success');
                        }
                        //Se oculta el loader para que no tape toda la pantalla por siempre.
                        else{
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })
    })()
</script>

<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";

    function getParameters() {
        var f_area = document.getElementById("_area_filtro").value;
        var f_ubicacion = document.getElementById("_subarea_filtro").value;
        var f_categoria = document.getElementById("_categoria_filtro").value;
        //var f_producto = document.getElementById("_producto_filtro").value;

        var table = $('#data-table').DataTable();
        fetch(SITEURL + '/filtrarProductos', {
            method: 'POST',
            body: JSON.stringify({
                area: f_area,
                ubicacion: f_ubicacion,
                categoria: f_categoria,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var almacen = "";
            var acciones = "";
            var foto = "";
            var url = "";
            table.clear();
            //console.log(data.lista)
            if (data.lista != null && data.lista.length != 0) {
                for (let i in data.lista) {
                    url = "{{ asset('imagen_productos/id') }}";
                    url = url.replace('id', data.lista[i].photo_prod);
                    foto = "<div>" +
                        "<img src='" + url + "' width='50ppx'" +
                        "id='imagenSeleccionada' alt='Foto actual del producto'>" +
                        "</div>";

                    url = "{{ route('productos.edit', 'id') }}";
                    url = url.replace('id', data.lista[i].id);

                    var acciones = "<td class=\"border-l px-4 py-2\">";
                    acciones += "<div class=\"flex justify-center rounded-lg text-lg\" role=\"group\">";
                    acciones += "<a href=\"" + url + "\"" +
                        "style=\"text-decoration: none\"" +
                        "class=\"rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 mx-2 ml-2\">Editar</a> ";

                    var url_borrar = '{{ route('productos.destroy', ':id') }}';
                    url_borrar = url_borrar.replace(':id', data.lista[i].id);

                    acciones += "<form action=\"" + url_borrar + "\" method=\"post\" class=\"formEliminar\">" +
                        "<input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token() }}\">" +
                        "<input type=\"hidden\" name=\"_method\" value=\"DELETE\">" +
                        "<button type=\"submit\" class=\"rounded bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 mx-2 ml-2 \">Eliminar</button>" +
                        "</form>";

                    acciones += "</div>";
                    acciones += "</td>";

                    almacen = data.lista[i].areas.area_nombre + ", ";
                    if (data.lista[i].subareas) {
                        almacen += data.lista[i].subareas.subarea_nombre;
                    } else {
                        almacen += data.lista[i].almacenes.almacen_nombre;
                    }

                    table.row.add([
                        data.lista[i].id,
                        data.lista[i].nombre_prod,
                        data.lista[i].unidad,
                        data.lista[i].stock_min,
                        data.lista[i].categoria.nombre_cat,
                        data.lista[i].existencias,
                        //data.lista[i].solicitados_cant,
                        almacen,
                        foto,
                        acciones
                    ]);
                }
            }
            table.draw();
        }).catch(error => alert(error));
    }
</script>
<script>
    //Actualizar subareas select dependiendo el area
    document.getElementById('_area_filtro').addEventListener('change', (e) => {
        fetch(SITEURL + '/subarea', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].subarea_clave + '">' + data.lista[i]
                    .subarea_nombre + '</option>';
            }
            opciones += "<option value='0' style='color: blue;'>Todas</option>";
            document.getElementById("_subarea_filtro").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
<script>
    $(document).ready(function(e) {
        $('#imagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
</script>
