<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consultar productos') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
        <style>
            .loader{
                width: 48px;
                height: 48px;
                border: 5px solid #b3b3b3;
                border-bottom-color: #22C55E;
                border-radius: 50%;
                display: inline-block;
                box-sizing: border-box;
                animation: rotation 2s linear infinite;
            }
            @keyframes rotation {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
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
    <div class="grid grid-cols-2 md:grid-cols-5 gap-5 md:gap-8 mt-5 mx-7">
        <div class="grid grid-cols-1">
            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Categoria:</label>
            <select id="_categoria_filtro" name="categoria_filtro"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-start align-items-center grid grid-cols-2 md:grid-cols-5 gap-5 md:gap-8 mt-2 mx-8">
        <label for="Productos Eliminados">
            <input type="checkbox" name="eliminados" id="eliminados" 
                class="py-2 px-3 rounded-lg border-2 mr-1" 
                style="background-color: #fff; border-color: #81C784; border-width: 2px; border-style: solid;" 
                onchange="if (this.checked) { this.style.backgroundColor = '#4CAF50'; this.style.borderColor = '#4CAF50'; } else { this.style.backgroundColor = '#fff'; this.style.borderColor = '#81C784'; }"
                onmouseover="this.style.borderColor = '#4CAF50';" 
                onmouseout="if (!this.checked) { this.style.borderColor = '#81C784'; }">
            <label for="eliminados" class="md:text-sm text-xs text-gray-500 font-semibold">MOSTRAR PRODUCTOS ELIMINADOS</label>
        </label>
    </div>

    <div class="grid grid-rows-1 place-items-center mt-3">
        <!-- botón Filtrar -->
        <button onClick="filtrarProductos()" style="text-decoration:none;"
            class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 mx-2 ml-2">Filtrar</button>
    </div>
    <div class="col-sm-12">
        
        @if ($errors->any())
            <div class="alert alert-warning mt-4">
                {{$errors->first()}}
            </div>            
        @endif

        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif
        
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6"
        style="width:95%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto ">
        
        <table id="data-table" class="stripe hover"
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
                    <th>ALMACEN</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>

        </table>
        {{-- @dd($productos) --}}
        <div class="flex place-content-end mt-5 mb-3">
            <div class="w-full flex justify-center" id="loading">
                <span class="loader"></span>
            </div>
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
    $(document).ready(function(){
        $.ajax({
            url: "{{ route('productos.fetch') }}",
            success: (response) => {
                $('#data-table').DataTable({
                    processing: true,
                    lengthMenu: [[25, 50], [25, 50]],
                    responsive: true,
                    autoWidth: false,
                    deferRender: true,
                    data : response.productos,
                    columns:
                        [
                            {title : "ID", data : "id"},
                            {title : "NOMBRE DEL PRODUCTO", data : "nombre_producto"},
                            {title : "TIPO DE UNIDAD", data : "unidad"},
                            {title : "STOCK MÍNIMO", data : "stock_minimo"},
                            {title : "CATEGORÍA", data : "categoria.nombre_categoria"},
                            {title : "CANTIDAD SOLICITADA", data : "solicitados_cant"},
                            {title : "EXISTENCIAS", data : "existencias"},
                            {title : "ALMACEN", data : "almacen"}, 
                            {title: "FOTO", data: "photo_prod",
                                render: function(data, type, row) {
                                    if (data) {
                                        return '<img src="/imagen_productos/' + data + '" alt="Foto del producto" width="50">';
                                    } else {
                                        return 'No disponible';
                                    }
                                }
                            },
                            {title : "ACCIONES", data : null, 
                                render: function(data, type, row) {
                                    var url_edit = '{{ route("productos.edit", ":id") }}';
                                    url_edit = url_edit.replace(':id', row.id);

                                    var url_borrar = '{{ route("productos.destroy", ":id") }}';
                                    url_borrar = url_borrar.replace(':id', row.id);

                                    return `<div class="flex justify-center rounded-lg text-lg" role="group">
                                                <a href="${url_edit}"
                                                    style="text-decoration: none"
                                                    class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 mx-2 ml-2">Editar</a>
                                                <button onclick="event.preventDefault(); document.getElementById('delete-form-${row.id}').submit();"
                                                    class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 mx-2 ml-2">Borrar</button>
                                                <form id="delete-form-${row.id}" action="${url_borrar}" method="post" style="display: none;">
                                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                </form>
                                            </div>`;
                                }
                            }
                        ],

                        initComplete : ()=>{
                            const loading = document.querySelector('#loading');
                            loading.remove();
                        },
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por página",
                        "zeroRecords": "No se encontraron resultados",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay registros disponibles",
                        "infoFiltered": "(filtrado de _MAX_ registros totales)",
                        "search": "Buscar: ",
                        "paginate": {
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                });
            }
        })
        
    });

    function filtrarProductos() {
        var categoria = document.getElementById("_categoria_filtro").value;
        var eliminados = document.getElementById("eliminados").checked ? 1 : 0;

        $.ajax({
            url: "{{ route('productos.filtrarP') }}",
            type: "POST",
            data: {
                categoria: categoria,
                eliminados: eliminados,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#data-table').DataTable().clear().rows.add(response.productos).draw();
            },
        });
    }

    // function getParameters() {

    //     $(document).ready(function(e) {
    //         $('#imagenSeleccionada').change(function() {
    //             let reader = new FileReader();
    //             reader.onload = (e) => {
    //                 $('#imagenSeleccionada').attr('src', e.target.result);
    //             }
    //             reader.readAsDataURL(this.files[0]);
    //         });
    //     });


    //     var f_categoria = document.getElementById("_categoria_filtro").value;
    //     var espera = document.getElementById("eliminados");
    //     var f_eliminados;
    //     if(espera.checked){f_eliminados = espera.value;}
    //     else{f_eliminados = 0;}
        
    //     var table = $('#data-table').DataTable();
    //     fetch(SITEURL + '/recargarCategorias', {
    //         method: 'POST',
    //         body: JSON.stringify({
    //             categoria: f_categoria,
    //             bandera: f_eliminados,
    //             "_token": "{{ csrf_token() }}"
    //         }),
    //         headers: {
    //             'Content-Type': 'application/json',
    //             "X-CSRF-Token": csrfToken
    //         },
    //     }).then(response => {
    //         return response.json()
    //     }).then(data => {

    //         var acciones = "";
    //         var foto = "";
    //         var almacen = "";
    //         table.clear();
    //         if (data.lista != null && data.lista.length != 0) {
    //             for (let i in data.lista) {
    //                 var url = '{{ route('productos.edit', ':id') }}';
    //                 url = url.replace(':id', data.lista[i].id);

    //                 var url_foto = '{{ asset('imagen_productos/' . ':photo_prod') }}';
    //                 url_foto = url_foto.replace(':photo_prod', data.lista[i].photo_prod);

    //                 var form_id = 'delete_form_' + data.lista[i].id;
                    
    //                 var acciones = "<td class=\"border-l px-4 py-2\">";
    //                 acciones += "<div class=\"flex justify-center rounded-lg text-lg\" role=\"group\">";
    //                 acciones += "<a href=\"" + url + "\"" +
    //                     "style=\"text-decoration: none\"" +
    //                     "class=\"rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 mx-2 ml-2\">Editar</a> ";

    //                 var url_borrar = '{{ route('productos.destroy', ':id') }}';
    //                 url_borrar = url_borrar.replace(':id', data.lista[i].id);

    //                 acciones += "<form action=\"" + url_borrar + "\" method=\"post\">" +
    //                     "<input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token() }}\">" +
    //                     "<input type=\"hidden\" name=\"_method\" value=\"DELETE\">" +
    //                     "<button name='boton"  + data.lista[i].id + "' type=\"submit\" class=\"rounded formEliminar bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 mx-2 ml-2\">Borrar</button>" +
    //                     "</form>";

    //                 acciones += "</div>";
    //                 acciones += "</td>";

    //                 //dd(data.lista[i].nombre_producto);
    //                 // Agregar un console.log() para verificar el nombre antes de añadir la fila a la tabla
    //                 //console.log('Nombre antes de añadir la fila:', data.lista[i].nombre_producto);

    //                 foto = "<td class=\"px-14 py-1\">" +
    //                     "<img src=\"" + url_foto + "\"" +
    //                     " width=\"50ppx\" " +
    //                     "id=\"imagenSeleccionada\" alt=\"Foto actual del producto\">" +
    //                     "</td>";

    //                 almacen = data.lista[i].areas.area_nombre + ", ";
    //                 if (data.lista[i].subareas) {
    //                     almacen += data.lista[i].subareas.subarea_nombre;
    //                 } else if (data.lista[i].almacenes) {
    //                     almacen += data.lista[i].almacenes.almacen_nombre;
    //                 } else {
    //                     almacen += "Unkwnow";
    //                 }
    //                 if(f_eliminados){acciones = "Producto Eliminado";}
                    
    //                 table.row.add([
    //                     data.lista[i].id,
    //                     data.lista[i].nombre_producto,
    //                     data.lista[i].unidad,
    //                     data.lista[i].stock_minimo,
    //                     data.lista[i].categoria.nombre_categoria,
    //                     data.lista[i].solicitados_cant,
    //                     data.lista[i].existencias,
    //                     almacen,
    //                     foto,
    //                     acciones
    //                 ]);
    //                 // Agregar un dd() para verificar el nombre después de agregar la fila a la tabla
    //                 //dd(data.lista[i].nombre_producto);
    //                 // Agregar un console.log() para verificar el nombre después de agregar la fila a la tabla
    //                 //console.log('Nombre después de añadir la fila:', data.lista[i].nombre_producto);
    //             }
    //         }
    //         table.draw();
    //     }).catch(error => alert(error));
        
    // }
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
    /*
    document.getElementById('_areas').addEventListener('change', (e) => {
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
            document.getElementById("_subareas").innerHTML = opciones;
        }).catch(error => alert(error));
    }) 

     document.getElementById('_divisiones').addEventListener('change', (e) => {
        fetch(SITEURL + '/areas', {
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
            var opciones1 = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].area_clave + '">' + data.lista[i]
                    .area_nombre + '</option>';
            }
            for (let i in data.listaSub) {
                opciones1 += '<option value="' + data.listaSub[i].subarea_clave + '">' + data.listaSub[
                    i].subarea_nombre + '</option>';
            }
            document.getElementById("_areas").innerHTML = opciones;
            document.getElementById("_subareas").innerHTML = opciones1;
        }).catch(error => alert(error));
    }) */
</script>

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
                        else{
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })
    })()
</script>
