<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consultar Mermas') }}
        </h2>
    </x-slot>


    @section('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">

        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            @if (session()->has('message'))
                <div class="px-2 inline-flex flex-row" id="mssg-status">
                    {{ session()->get('message') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @elseif(session()->has('error'))
                <div class="px-2 inline-flex flex-row py-1 text-black" id="mssg-status">
                    {{ session()->get('error') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" style="width:100%;">
                <div class="mt-8 mb-6 px-4 py-3 ml-5 leading-normal text-green-500 rounded-lg" role="alert">
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

                <table id="data-table" class="stripe hover translate-table"
                    style="width:94%; padding-top: 1em;  padding-bottom: 1em;">

                    <thead>
                        <tr>
                            <th>PRODUCTO</th>
                            <th>ALMACEN</th>
                            <th>N.° MERMAS</th>
                            <th>QUIEN REPORTA</th>
                            <th>REPORTE</th>
                            <th>FECHA</th>
                            <th>ACCIONES</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mermas as $merma)
                            <tr data-id="{{ $merma->id }}">
                                <td>{{ $merma->producto->nombre_producto }}</td>
                                @if (App\Models\Almacen::find($merma->producto->subarea))
                                    <td>{{ App\Models\Almacen::find($merma->producto->subarea)->almacen_nombre }}</td>
                                @else
                                    <td>{{ App\Models\Subarea::find($merma->producto->subarea)->subarea_nombre }}</td>
                                @endif
                                <td>{{ $merma->cantidad }}</td>
                                <td>{{ $merma->eid }}</td>
                                <td><a href={{asset("reportes/".$merma->archivo)}} target="_blank" rel="noopener noreferrer">{{ $merma->archivo}}</a></td>
                                <td>{{ $merma->created_at->format ('d/m/Y') }}</td>
                                <td class=" px-4 py-2">
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        @if ($merma->status == 'pendiente')
                                            <!-- botón Autorizar -->
                                            <form action="{{ route('mermas.autorizarMermas') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="merma" value="{{$merma->id}}" />
                                                <input style="text-decoration: none" type="submit" value="Autorizar"
                                                    class="cursor-pointer rounded bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 mx-auto mr-2" />
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    {{$merma->status}}
                                </td>

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
