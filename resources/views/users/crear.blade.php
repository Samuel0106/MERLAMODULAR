<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('users.store') }}" method="POST" class="formEnviar" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->count() > 0)
                    <div id="ERROR_COPY" style="display:none " class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        {{ $error }} <br />
                        @endforeach
                    </div>

                    @endif
                    {{-- <x-jet-validation-errors class="mb-4 gap-5 md:gap-8 mt-5 mx-7" /> --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                            <input name="eid"
                                class=" @error('eid') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                maxlength="5" type="text" required />
                            @error('eid')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Email:</label>
                            <input name="email"
                                class=" @error('email') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            @error('email')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                            <input name="nombre"
                                class=" @error('nombre') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            @error('nombre')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido
                                paterno:</label>
                            <input name="paterno"
                                class=" @error('paterno') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            @error('paterno')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido
                                materno:</label>
                            <input name="materno"
                                class=" @error('materno') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            @error('materno')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                                antigüedad:</label>
                            <input name="ingreso"
                                class=" @error('ingreso') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="date" required />
                            @error('ingreso')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Contrato:</label>
                            <select name="contrato" id="contrato"
                                class="@error('contrato') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option id="SINDICALIZADO TEMPORAL" value="7">
                                    SINDICALIZADO TEMPORAL
                                </option>
                                <option id="SINDICALIZADO BASE" value="6">
                                    SINDICALIZADO BASE
                                </option>
                                <option id="CONFIANZA TEMPORAL" value="2">
                                    CONFIANZA TEMPORAL
                                </option>
                                <option id="CONFIANZA BASE" value="1">
                                    CONFIANZA BASE
                                </option>
                                <option id="JUBILADO" value="3">
                                    JUBILADO
                                </option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">PUESTO:</label>
                            <select id="_puesto" name="puesto"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required>
                                @foreach (App\Models\Puesto::all() as $puesto)
                                    <option id="{{ $puesto->id }}" value="{{ $puesto->nombre_puesto }}">
                                        {{ $puesto->nombre_puesto }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">División:</label>

                            <select id="_division_filtro" name="division"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($divisiones as $division)
                                    <option <?php if ($division->division_clave == Auth::user()->datos->getDivision->division_clave) {
                                        print 'selected';                                        
                                    } ?> value="{{ $division->division_clave }}">{{ $division->division_nombre }}</option>

                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Área:</label>
                            <select id="_area_filtro" name="area"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($areas as $area)
                                    <option <?php if ($area->area_clave == Auth::user()->datos->getArea->area_clave) {
                                        print 'selected'; 
                                    } ?> value="{{ $area->area_clave }}">{{ $area->area_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="block uppercase md:text-sm text-xs text-gray-500 font-semibold">Subárea:</label>
                            <select id="_subarea_filtro" name="subarea"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($subareas as $subarea)
                                    <option  <?php if ($subarea->subarea_clave == Auth::user()->datos->getSubarea->subarea_clave) {
                                        print 'selected';
                                    } ?> value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Contraseña:</label>
                            <input name="password" id = "password"
                                 placeholder="Si se deja en blanco se configura contraseña default"

                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="password" />
                            @error('password')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <center>
                        @error('roles')
                        <span style="font-size: 10pt;color:red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        <table id="data-table" class="grid grid-cols-1 place-items-center" style="width:50%; padding-top: 1em;  padding-bottom    : 1em; border-spacing: 5px;
                        border-collapse: separate;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Roles</th>
                                </tr>
                            </thead>

                            @foreach ($roles as $role)
                                <tr data-id="{{ $role->name }}">

                                    <td><input type="checkbox" name="roles[]" id="roles"
                                            value="{{ $role->name }}"></td>
                                    <td
                                        style="
                            direction:lft;
                            text-align:justify;"">
                                        {{ $role->name }} </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </center>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('users.index') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit"
                            class='w-auto bg-blue-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form
        var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
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
                            Swal.fire('¡Enviado!', 'El registro ha sido enviado exitosamente.',
                                'success');
                        } else {
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
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
    //Actualizar areas select dependiendo la division
    document.getElementById('_division_filtro').addEventListener('change', (e) => {
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
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].area_clave + '">' + data.lista[i]
                    .area_nombre + '</option>';
            }
            document.getElementById("_area_filtro").innerHTML = opciones;

            fetch(SITEURL + '/subarea', {
                method: 'POST',
                body: JSON.stringify({
                    texto: data.lista[0].area_clave,
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
                    opciones += '<option value="' + data.lista[i].subarea_clave + '">' + data
                        .lista[i].subarea_nombre + '</option>';
                }
                document.getElementById("_subarea_filtro").innerHTML = opciones;
            }).catch(error => alert(error));

        }).catch(error => alert(error));
    })

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
            document.getElementById("_subarea_filtro").innerHTML = opciones;
        }).catch(error => alert(error));
    })
</script>
<script>
    //VALIDAR SI HAY ERRORES EN LOS DATOS Y MOSTRAR CADA ERROR
    var has_errors = {{ $errors->count() > 0 ? 'true' : 'false' }};
    if (has_errors) {
        Swal.fire({
            title: 'Advertencia 273',
           icon: 'info',

            html: jQuery("#ERROR_COPY").html(),
            showCloseButton: true,
        });
    }
</script>

