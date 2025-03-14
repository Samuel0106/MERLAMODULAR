<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario General') }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="mt-4 px-4 py-3 ml-11 leading-normal text-green-500 rounded-lg" role="alert">
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
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6"
        style="width:95%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto ">
        <table id="data-table" class="stripe hover translate-table"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-white">
                <tr class="bg-gray-800 text-white">
                    <th>ID</th>
                    <th>NOMBRE DEL PRODUCTO</th>
                    <th>TIPO DE UNIDAD</th>
                    <th>STOCK MÍNIMO</th>
                    <th>CATEGORÍA</th>
                    <th>EXISTENCIAS</th>
                    <th>ÁREA</th>
                    <th>ALMACEN</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($productos as $producto)
                    <tr data-id="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre_producto }}</td>
                        <td>{{ $producto->unidad }}</td>
                        <td>{{ $producto->stock_minimo }}</td>
                        <td>{{ $producto->categoria->nombre_categoria }}</td>
                        <td>{{ $producto->existencias }}</td>
                        <td>{{ App\Models\Area::find($producto->area)->area_nombre }}</td>
                        <td>{{ App\Models\Almacen::find($producto->subarea)->almacen_nombre }}</td>
                        <td class="px-14 py-1">
                            @if ($producto->photo_prod != null)
                                <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} " width="50ppx"
                                    id="imagenSeleccionada" alt="Foto actual del producto">
                            @else
                                <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                    width="50ppx" id="imagenSeleccionada"
                                    alt="Foto actual del producto">
                            @endif
                        </td>

                        <td class="border-l px-4 py-2">
                            <div class="flex justify-center rounded-lg text-lg" role="group">
                                <!-- botón editar -->
                                <a href="{{ route('productos.edit', $producto->id) }}" style="text-decoration:none;"
                                    class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 mx-2 ml-2">Editar</a>

                                <!-- botón borrar -->
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                    class="rounded formEliminar bg-red-600 hover:bg-red-700 ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded text-white font-bold py-2 px-2 mx-2 ml-2">Borrar</button>
                                </form>

                            </div>
                        </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>


            </table>

        </table>
        <div class="grid place-content-end mt-5 mb-3">
            <a type="button" href="{{ route('productos.create') }}"
                class="bg-blue-600 px-12 py-2 rounded text-white font-semibold hover:bg-blue-700 transition duration-200 each-in-out">
                Crear</a>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
</x-app-layout>
