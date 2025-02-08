<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar nuevo producto') }}
        </h2>
    </x-slot>
    <style>
        .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        }
        
        .alert-danger {
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
        }
        
        .alert-success {
        background-color: #dff0d8;
        border-color: #d6e9c6;
        color: #3c763d;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="my-4 px-3 py-3 ml-4  leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ url()->previous() }}"
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
                <form id="productoForm" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="formEnviar">
                    @csrf
                    @if($pedidoesp)
                        <input hidden name="id_pedidoesp" value={{$pedidoesp->id}} />
                    @endif

                    <div class="grid grid-cols-1 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="col-sm-12">
                            @if($mensaje = Session::get('success'))
                                <div class="alert alert-success" role="alert">
                                {{ $mensaje }}
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-12">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre del
                                Producto:</label>
                            <input name="nombre_prod" style="border-color: rgb(21 128 61);"
                                class="py-1 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required @if($pedidoesp) value='{{$pedidoesp->nombre_prod}}' @endif />
                                
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="py-2 ml-2 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Unidad</label>
                            <select name="unidad" id="unidad"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required >
                                <option id="unidad1" value="Piezas">Piezas</option>
                                <option id="unidad2" value="Cajas">Cajas</option>
                                <option id="unidad3" value="Paquetes">Paquetes</option>
                                <option id="unidad4" value="Metros">Metros</option>
                                <option id="unidad5" value="Litros">Litros</option>
                                <option id="unidad6" value="Kilogramos">Kilogramos</option>
                                <option id="unidad7" value="Galones">Galones</option>
                                <option id="unidad8" value="Bolsa">Bolsa</option>
                                <option id="unidad9" value="Block">Block</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Stock Mínimo:</label>
                            <input
                                name="stock_min"
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="number"
                                min="0"
                                pattern="\d+"
                                oninput="validity.valid||(value='');"
                                required
                            />
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Categoría:</label>
                            <select name="categoria_id" id="categoria_id"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required>
                                @foreach ($categorias as $categoria)
                                    <option id="{{ $categoria->id }}" value="{{ $categoria->id }}">
                                        {{ $categoria->nombre_cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                ÁREA:</label>
                            <input disabled name="area" value='{{ App\Models\Area::find($area)->area_nombre }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            <input name="area" value='{{ $area }}' style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="hidden py-2 px-3 rounded-lg border-2  border-blue-600 mt-1 focus:outline-none focus:ring-2 
                                focus:ring-blue-700 focus:border-transparent" type="text" required />
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold"> ALMACEN:</label>
                            <select name="subarea" required
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @if (Auth::user()->can('producto.TodosAlmacenes'))
                                    @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->almacen_clave }}">{{ $almacen->almacen_nombre }}
                                        </option>
                                    @endforeach
                                @elseif(empty($almacen_clave))
                                    <option value="">{{ '-No eres Jefe de ningún almacen activo-' }}</option>
                                @else
                                    <option value="{{ $almacen_clave }}" selected> {{ $almacen_nombre }} </option>
                                @endif
                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Existencias:</label>
                            <input
                                name="existencias"
                                style="border-color: rgb(21 128 61);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="number"
                                min="0"
                                pattern="\d+"
                                oninput="validity.valid||(value='');"
                                required
                                @if($pedidoesp) value='{{$pedidoesp->cantidad}}' @endif
                            />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-5 md:gap-8 mt-5 mx-7">
                        <div class='flex items-center justify-center w-full'>
                            <label class='flex flex-col hover:bg-green-7000 hover:border-blue-600 group'>
                                <div class='flex flex-col items-center justify-center pt-7 relative'>
                                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Foto Producto</label>
                    
                                    <div id="photo_container" class="relative">
                                        
                    
                                        <img id="photo_prod"
                                            style="max-height: 200px; max-width: 290px; min-height: 200px; min-width: 230px;"
                                            class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent hover:bg-green-7000 hover:border-blue-600">
                                        
                                            <p class='absolute inset-0 flex items-center justify-center text-green-600 hover:text-green-800'
                                            id="addImageText">
                                            <svg class="w-10 h-10 text-green-400 group-hover:text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg> Seleccione la imagen
                                            </p>
                                        <input name="photo_prod" id="imagen" type='file' class="hidden" style="z-index: 2;">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <script>
                        document.getElementById('photo_container').addEventListener('click', function() {
                            // document.getElementById('imagen').click();
                            var addImageText = document.getElementById('addImageText');
                            addImageText.style.visibility = 'hidden';
                            addImageText.style.opacity = '0';
                        });
                    </script>
                    
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ url()->previous() }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <!-- botón enviar -->
                        <form action="{{ route('productos.index') }}" method="POST"
                            class="formEnviar w-auto bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
                            @csrf
                            <button type="submit" onclick="validarNombre()"
                                class="w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-7 py-2">Enviar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
<script>
    function validarNombre() {
        // Obtén el valor del nombre del producto
        var nombreProducto = document.getElementById('nombre_prod').value;

        // Puedes agregar tu lógica de validación aquí, por ejemplo, verificar que el nombre no esté vacío
        if (nombreProducto.trim() === '') {
            // Si el nombre está vacío, muestra una alerta o realiza alguna acción
            alert('Por favor, ingrese un nombre de producto válido.');
        } else {
            // Si el nombre es válido, puedes enviar el formulario
            document.getElementById('productoForm').submit();
        }
    }
    $(document).ready(function(e) {

        $('#imagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#photo_prod').attr('src', e.target.result);

            }
            reader.readAsDataURL(this.files[0]);
        });

    });

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
    /* document.getElementById('_areas').addEventListener('change', (e) => {
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
    }) */

/*     document.getElementById('_divisiones').addEventListener('change', (e) => {
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

    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form  
        var forms = document.querySelectorAll('.formEnviar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirmar el envio?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            // Swal.fire('¡Enviado!', 'El registro ha sido enviado exitosamente.',
                            //     'success');
                                
                        } else {
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })
    })()
</script>
