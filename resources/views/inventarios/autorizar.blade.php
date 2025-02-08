<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autorizar pedidos') }}
        </h2>
    </x-slot>

    @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">

        <div class="mx-auto sm:px-6 lg:px-8">
            @if (session()->has('error'))
            <div class="px-2 inline-flex flex-row mb-4" id="mssg-status">
                {{ session()->get('error') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                </li>
            </div>
            @endif
            @if (session()->has('message'))
            <div class="px-2 inline-flex flex-row mb-4" id="mssg-status">
                {{ session()->get('message') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <div class="my-4 px-3 py-3 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ route('inventarios.inicio') }}" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                            </svg>
                            Regresar
                        </a>
                    </div>
                </div>
                <table id="data-table" class="stripe hover translate-table" style="width:97%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>N.º PEDIDO</th>
                            <th>eid</th>
                            <th>NOMBRE</th>
                            <th>EMAIL</th>
                            <th>ALMACEN DE ORIGEN</th>
                            <th>CENTRO DE DESTINO</th>
                            <th>FECHA CREACION</th>
                            <th>Fecha Estimada</th>
                            <th>STATUS</th>
                            <th>ACCIONES</th>

                        </tr>
                    </thead>
                    @can('inventarios.autorizar')
                    <tbody>
                        @foreach ($inventariosPendientes as $inventario)
                        <tr data-id="{{ $inventario->id }}">
                            <td>{{ $inventario->id }}</td>
                            <td>{{ $inventario->eid }}</td>
                            <td>{{ $inventario->nombre }}</td>
                            <td>{{ $inventario->email }}</td>

                            @if(App\Models\Almacen::find($inventario->almacen) != null)
                            <td>{{ App\Models\Almacen::find($inventario->almacen)->almacen_nombre }}</td>
                            @else
                            <td>-</td>
                            @endif

                            @if(App\Models\Subarea::find($inventario->subarea) != null)
                            <td>{{ App\Models\Subarea::find($inventario->subarea)->subarea_nombre }}</td>
                            @else
                            <td>-</td>
                            @endif

                            <td>{{ $inventario->created_at->format('Y-m-d') }}
                            <td>{{ !is_null($inventario->fecha_estimada) ? $inventario->fecha_estimada : 'N/A' }}</td>
                            <td>{{ $inventario->status }}</td>

                            <td>
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <a href="{{ route('inventarios.autorizarProductos', ['inventario' => $inventario->id]) }}" style="text-decoration:none;" class="rounded bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-auto">Ver</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endcan
                </table>

            </div>
        </div>
    </div>

    @section('js')
    <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/customDataTables.js') }}"></script>
    <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js')}}"></script>
    @endsection
</x-app-layout>