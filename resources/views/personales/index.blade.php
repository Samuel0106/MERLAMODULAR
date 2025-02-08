<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Antecedentes Personales') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>eid</th>
                            <th>Area</th>
                            <th>Subarea</th>
                            <th>Vacunas</th>
                            <th>Fecha</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antecedentes_personales as $personal)
                            <tr data-id="{{ $personal->id }}">
                                <td>{{ $personal->eid }}</td>
                                <td>{{ App\Models\Area::find($personal->area)->area_nombre}}</td>
                                <td>{{ App\Models\Subarea::find($personal->subarea)->subarea_nombre}}</td>
                                <td>{{ $personal->vacuna }}</td>
                                <td>{{ $personal->fecha }}</td>
                                <td>
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        <!-- botón ver -->
                                        <a style="text-decoration: none"
                                            href="{{ route('personales.edit', $personal->id) }}"
                                            class=" mx-auto rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4">Ver</a>
                                        <!-- botón borrar -->
                                        <form action="{{ route('personales.destroy', [$personal->id, $eid]) }}"
                                            method="POST"
                                            class="formEliminar mx-auto rounded-lg bg-red-600 hover:bg-red-700 ">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class=" rounded text-black font-bold py-2 px-4">Borrar</button>
                                        </form>
                                    </div>
                                </td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="flex items-center justify-center  md:gap-8 gap-4 pb-5">
                    <!-- botón volver -->
                    <a type="button" href="{{ route('datos.index') }}" style="text-decoration:none"
                        class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Volver</a>
                    <!-- botón crear -->
                    <a type="button" href="{{ route('personales.create', $eid) }}" style="text-decoration:none"
                        class="rounded-lg bg-blue-600 hover:bg-blue-500 text-black font-bold py-2 px-4"> Crear</a>
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
        var loader = document.getElementById("preloader");    //Se guarda el loader en la variable.
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
                        else {
                            //Se oculta el loader para que no tape toda la pantalla por siempre.
                            loader.style.display = "none";
                        }
                    })
                }, false)
            })

    })()
</script>
