<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reponer Productos') }}
        </h2>
    </x-slot>

    @section('css')
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection
    <div class="py-10">
        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <!--            <button type="submit" class="rounded text-white font-bold py-2 px-4">Borrar</button> -->

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 " style="width:100%;">
                
                <form action= "{{ route('inventarios.store') }}" method="post" id="formGuardar">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                            <input disabled name="eid" value='{{ $datos->eid }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">NOMBRE:</label>
                            <input disabled name="nombre" value="{{$datos->paterno . ' ' . $datos->materno . ', ' . $datos->nombre}}"
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-grey-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">EMAIL:</label>
                            <input disabled name="email" value='{{ $email }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                ÁREA DEL ALMACEN AL QUE SE LE SOLICITA PRODUCTOS:
                            </label>
                            <input disabled name="area" value='{{ $area }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                ÁREA DEL CENTRO DE TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <input disabled name="area1" value='{{ $area }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO
                                DE
                                TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <input disabled name="subarea" value='{{ $subarea }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                    </div>
                </form>
                <br>

                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>

                            <th>NOMBRE DEL PRODUCTO</th>
                            <th>TIPO DE UNIDAD</th>
                            <th>CATEGORIA</th>
                            <th>EXISTENCIAS</th>
                            <th>SOLICITUDES</th>
                            <th>FOTO</th>
                            <th>REPONER PRODUCTO</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            @if($producto->existencias!=0)
                                @continue
                            @elseif($producto->solicitados_cant == null)
                                @continue
                            @elseif($producto->solicitados_cant <= 0)
                                @continue
                            @endif
                            
                            <!--muestra los productos que NO tienen existencias y SI tengan solicitudes-->
                            <tr>
                                <td class="px-6 py-4 text-center">
                                    <div>
                                        {{ $producto->nombre_prod }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div>
                                        {{ $producto->unidad }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div>
                                        {{ $producto->categoria->nombre_cat }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div>
                                        {{ $producto->existencias }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{$producto->solicitados_cant}}
                                </td>
                                <td>
                                    @if ($producto->photo_prod != null)
                                        <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} "
                                            width="50ppx" id="imagenSeleccionada"
                                            alt="Foto actual del producto">
                                    @else
                                        <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                            width="50ppx" id="imagenSeleccionada"
                                            alt="Foto actual del producto">
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                        <button type="button"
                                            class="rounded text-white font-bold py-1 px-2 inline-flex"><a href="{{ route('productos.editI', $producto->id) }}">Reponer producto</a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        @endsection
    </div>
</x-app-layout>