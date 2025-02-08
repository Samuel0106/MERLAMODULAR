<x-app-layout>
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}
    
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Agregar Roles') }}
    </h2>
    </x-slot>
    <style>
        /* CHECKBOX TOGGLE SWITCH */
        /* @apply rules for documentation, these do not work as inline style */
        .toggle-checkbox:checked {
            @apply: right-0 border-green-400;
            right: 0;
            border-color: #68D391;
        }

        .toggle-checkbox:checked+.toggle-label {
            @apply: bg-green-400;
            background-color: #68D391;
        }
    </style>

    @if (session('info'))
        <div class="alert alert-success" role="alert">
            {{ session('info') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <center>
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data"
                        class="formEnviar">
                        @method('PATCH')
                        @csrf
                        {{-- <x-jet-validation-errors class="mb-4 gap-5 md:gap-8 mt-5 mx-7" /> --}}
                        <div class="grid grid-cols-1 gap-5 md:gap-8 mt-5 mx-7  place-items-center">
                            <div class="grid grid-cols-1">
                                @error('nombre')
                                    <span style="font-size: 10pt;color:red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input id="id" name="id" value={{ $role->id }} hidden />
                                <div id="container"></div>
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-dark font-semibold">Nombre
                                    del rol:</label>
                                <input name="nombre" value="{{ $role->name }}"
                                    class="py-2 px-3 rounded-lg border-2 border-green-300 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                    type="text" required />
                            </div>
                        </div>
                        <br>
                        <table id="data-table" class="stripe hover translate-table center display" style="width:50%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th align="left">Permiso</th>
                                    <th align="left">Descripcion</th>
                                </tr>
                            </thead>
                            @error('permisos')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @foreach ($permissions as $permission)
                                <tr data-id="{{ $permission->name }}">

                                    <td><input type="checkbox" name="permisos[]" id="permissions"
                                            value="{{ $permission->id }}"
                                            @if ($role->permissions->contains($permission->id)) checked=checked @endif></td>
                                    <td>
                                        {{ $permission->name }} </td>
                                    <td>{{ $permission->description }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                            <a href="{{ route('roles.index') }}"
                                class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                            <!-- botón enviar -->
                            <form action="{{ route('roles.store') }}" method="POST"
                                class="formEnviar w-auto bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
                                <button id="btnSubmit" name="btnSubmit" type="submit"
                                    style="background-color: rgb(21 128 61);"
                                    class="w-auto bg--500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                            </form>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#data-table').dataTable({
                    "bDestroy": true,
                    "pageLength": 100
                });
            });
        </script>
    @endsection
</x-app-layout>
<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form  
        var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
        var forms = document.querySelectorAll('.formEnviar');
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
                            Swal.fire('¡Enviado!', 'El rol se ha modificado con éxito.',
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


