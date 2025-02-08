<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial '. $producto->nombre_prod . ', ' . $producto->ubicacion) }}
        </h2>
    </x-slot>


    @section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">

        <div class="mx-auto sm:px-6 lg:px-8" style="width:70rem;">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" style="width:100%;">
                <div class="mt-8 mb-6 px-4 py-3 ml-5 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ (url()->previous()) }}" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                            </svg>
                            Regresar
                        </a>
                    </div>
                </div>

                <table id="data-table" class="stripe hover translate-table" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">

                    <thead>
                        <tr>
                            <th>Eliminado por: </th>
                            <th>Existencias Eliminadas</th>
                            <th>Fecha</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bajas as $baja)
                        <tr data-id="{{ $baja->id }}">
                            <td>{{ $baja->eid }}</td>
                            <td>{{ $baja->consumidos }}</td>
                            <td>{{ $baja->created_at->format('d/m/Y')}}</td>
                            @if(file_exists(public_path() . '/reportes/' . $baja->archivo))
                                <td><a href="{{asset('reportes/' . $baja->archivo)}}" target="_blank" rel="noopener noreferrer">{{ $baja->archivo}}</a></td>
                            @else
                                <td>N/A</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>

                </table>
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
        @endsection
</x-app-layout>