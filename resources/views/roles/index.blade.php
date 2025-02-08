<x-app-layout>




    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>

    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold"><a href="{{ route('roles.create') }}"
                                class="underline text-green-900">Crear nuevo rol</a>
                        </div>
                    </div>
                </div>
                <table id="data-table" class="stripe hover translate-table"
                    style="width:70%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">Rol</th>
                            <th style="text-align: center">Número de usuarios</th>

                            @can('roles.edit')
                                <th style="text-align: center">Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr data-id="{{ $rol->rol_name }}">
                                <td style="text-align: center">{{ $rol->id }}</td>
                                <td style="text-align: center">{{ $rol->name }}</td>
                                <td style="text-align: center">{{ count($rol->users) }}</td>
                                <td style="text-align: center" class="px-4 py-2">
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('roles.edit', $rol->id) }}" style="text-decoration: none"
                                            class="rounded bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 ml-2">Editar</a>
                                        <!-- Botón Borrar -->
                                        <form action="{{ route('roles.destroy', $rol->id) }}" method="POST"
                                            class="formEliminar rounded bg-red-600 hover:bg-red-700 text-black font-bold py-2 px-4 ml-2" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded text-black font-bold">Borrar</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
</x-app-layout>


<script>
    (function() {
        'use strict'

        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form  
        var loader = document.getElementById("preloader");
        var forms = document.querySelectorAll('.formEliminar');
                // let count = $(.form).data('data-value');
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la eliminación del Rol?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Eliminado!', 'El Rol ha sido eliminado exitosamente.',
                                'success');
                        }//Se oculta el loader para que no tape toda la pantalla por siempre.
                        else{
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })
    })()
</script>
