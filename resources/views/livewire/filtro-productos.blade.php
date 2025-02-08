<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6"
        style="width:90%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto ">
        <div id="preloader-livewire" wire:loading >
        </div>
        {{-- <div style="width:50%; margin-left: 20px; margin-top:40px; margin-bottom: 1em ">
            <div class="grid grid-cols-1">
                <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold"> Filtrar por Categoría:</label>
                <select name="categoria_id" id="categoria_id" wire:model="categoriaSeleccionada"
                wire:change="cambioCategoria"
                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    required />
                    <option id="0" value="0">Todos</option>
                @foreach ($categorias as $categoria)
                    <option id="{{ $categoria->id }}" value="{{ $categoria->id }}">{{ $categoria->nombre_cat }}</option>
                @endforeach

                </select>
            </div>
        </div> --}}
        <table id="data-table" class="stripe hover translate-table"
            style="width:95%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-white">
                <tr class="bg-gray-800 text-white">
                    <th>ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>NOMBRE DEL PRODUCTO</th>
                    <th>TIPO DE UNIDAD</th>
                    <th>STOCK MÍNIMO</th>
                    <th>CATEGORÍA&nbsp;&nbsp;&nbsp;</th>
                    <th>EXISTENCIAS&nbsp;&nbsp;&nbsp;</th>
                    <th>ALMACEN&nbsp;&nbsp;</th>
                    <th>FOTO</th>
                    <th>ACCIONES</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($productosAlmacen as $producto)
                    <tr data-id="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre_prod }}</td>
                        <td>{{ $producto->unidad }}</td>
                        <td>{{ $producto->stock_min }}</td>
                        <td>{{ $producto->categoria->nombre_cat }}</td>
                        <td>{{ $producto->existencias }}</td>
                        @if($producto->subareas)
                            <td>{{ $producto->areas->area_nombre }} , {{ $producto->subareas->subarea_nombre }}</td>
                        @else
                            <td>{{ $producto->areas->area_nombre }} , {{ $producto->almacenes->almacen_nombre }}</td>
                        @endif 
                        <td class="px-14 py-1">
                            @if ($producto->photo_prod != null)
                                <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} " width="50ppx"
                                    id="imagenSeleccionada" alt="Foto actual del producto">
                            @else
                                <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                    width="50ppx" id="imagenSeleccionada" alt="Foto actual del producto">
                            @endif
                        </td>

                        <td class="border-l px-4 py-2">
                            <div class="flex justify-center rounded-lg text-sm" role="group">
                                <!-- botón editar -->
                                <a href="{{ route('productos.editI', $producto->id) }}" style="text-decoration:none;"
                                    class="rounded bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 mx-2 ml-2">Agregar</a>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>


        </table>
       
    </div>

