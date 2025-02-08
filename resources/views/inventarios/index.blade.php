<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consultar pedidos') }}
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
            @if (session()->has('message'))
            <div class="px-2 inline-flex flex-row" id="mssg-status">
                {{ session()->get('message') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            @elseif(session()->has('error'))
            <div class="px-2 inline-flex flex-row py-1 text-black" id="mssg-status">
                {{ session()->get('error') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            @endif


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5">
                <div class="mt-8 mb-6 px-4 py-3 ml-5 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ route('inventarios.inicio') }}" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
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
                            <th>N.° PEDIDO</th>
                            <th>ALMACEN DE ORIGEN</th>
                            <th>CENTRO DE DESTINO</th>
                            <th>FECHA CREACIÓN</th>
                            <th>FECHA AUTORIZACIÓN</th>
                            <th>FECHA ENTREGA</th>
                            <th>FECHA ESTIMADA</th>
                            <th>STATUS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventarios as $inventario)
                        <tr data-id="{{ $inventario->id }}">
                            <td>{{ $inventario->id }}</td>
                            @if(App\Models\Almacen::find($inventario->almacen))
                            <td>{{ App\Models\Almacen::find($inventario->almacen)->almacen_nombre }}</td>
                            @else
                            <td>{{ App\Models\Subarea::find($inventario->almacen)->subarea_nombre }}</td>
                            @endif

                            @if(App\Models\Subarea::find($inventario->subarea))
                            <td>{{ App\Models\Subarea::find($inventario->subarea)->subarea_nombre }}</td>
                            @else
                            <td>{{ App\Models\Almacen::find($inventario->subarea)->almacen_nombre }}</td>
                            @endif
                            <td>{{ $inventario->created_at->format('Y-m-d')}}</td>
                            <td>{{ $inventario->fecha_autorizado}}</td>
                            <td>{{ $inventario->fecha_entrega}}</td>
                            <td>{{ !is_null($inventario->fecha_estimada) ? $inventario->fecha_estimada : 'N/A' }}</td>
                            <td>{{ $inventario->status }}</td>

                            <td class=" px-4 py-2">
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <!-- botón Ver -->
                                    <a href="{{ route('inventarios.show', $inventario->id) }}" style="text-decoration: none" class="rounded bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-4 mx-2 mr-2">Ver</a>
                                    <!-- botón borrar -->
                                    @if ($inventario->status == 'Pendiente')
                                    <form action="{{ route('inventarios.destroy', $inventario->id) }}" id="formEliminar{{ $inventario->id }}" method="POST" class="formEliminar mx-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 mx-auto">Borrar</button>
                                    </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

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
<script>
    <?php foreach ($inventarios as $inventario) { ?>
        $("#formEliminar{{ $inventario->id }}").submit(function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Seguro que quieres eliminar este pedido?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formEliminar{{ $inventario->id }}').submit();
                }
                //Se oculta el loader para que no tape toda la pantalla por siempre.
                else {
                    loader.style.display = "none";
                }
            });
        });
    <?php } ?>
</script>