<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorías') }}
        </h2>
    </x-slot>

    @section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('/resources/css/customDataTables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-6">

        <div class="mt-2 px-4 py-3 ml-11 mb-6 leading-normal text-green-500 rounded-lg" role="alert">
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
            <div class="px-2 inline-flex flex-row bg-blue-500 py-1 text-white" id="mssg-status">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session()->get('message') }}
            </div>
            @elseif(session()->has('error'))
            <div class="px-2 inline-flex flex-row bg-red-600 py-1 text-white" id="mssg-status">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                {{ session()->get('error') }}
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table id="data-table" class="table table-striped table-bordered shadow-lg table-fixed w-full  translate-table">
                    <thead>
                        <tr class="bg-gray-800 text-white">

                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">NOMBRE DE LA CATEGORÍA</th>
                            @if(@Auth::user()->hasRole('admin'))
                                <th class="border px-4 py-2">ACCIONES</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td style="display: none;">{{ $categoria->id }}</td>

                                <td>{{ $categoria->id }}</td>
                                <td>{{ $categoria->nombre_cat }}</td>
                                @if(@Auth::user()->hasRole('admin'))
                                    <td class="border px-4 py-2">
                                        <div class="flex justify-center rounded-lg text-lg" role="group">
                                            <!-- botón editar -->

                                            <a href="{{ route('categorias.edit', $categoria->id) }}"
                                                style="text-decoration:none;"
                                                class="rounded formEditar bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 mx-2">Editar</a>

                                        <!-- botón borrar -->
                                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" id="formEliminar{{$categoria->id}}" class="rounded bg-red-600 hover:bg-red-600">
                                            @csrf
                                            @method('DELETE')
                                            <button id="boton{{$categoria->id}}" type="submit" class="rounded text-white font-bold py-2 px-3 mx-2">Borrar</button>
                                        </form>

                                        </div>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>

                </table>


            </div>
        </div>
    </div>
</x-app-layout>

@section('js')
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
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
    <?php foreach ($categorias as $categoria) { ?>

        $("#formEliminar{{$categoria->id}}").submit(function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Seguro que quieres eliminar esta categoria?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formEliminar{{$categoria->id}}').submit();
                }
                //Se oculta el loader para que no tape toda la pantalla por siempre.
                else{
                    loader.style.display = "none";
                }
            });
        });

    <?php } ?>
</script>
@endsection
