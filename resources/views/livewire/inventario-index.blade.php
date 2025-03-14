<div>
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
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5"
        style="width:95%; margin-top: 22px; margin-bottom: 5em; margin-right:auto; margin-left:auto ">
        <div>
            <select wire:model='categoriaSelect' wire:change='actualizarDatos' class="py-2 px-3 rounded-lg mt-4 focus:outline-none focus:ring-2 focus:border-transparent" >
                <option value=0>Todas las categorias</option>
                {{-- <option value=1>Papeleria</option> --}}
                @foreach ($categorias as $cat)
                    <option value={{$cat->id}}>{{$cat->nombre_categoria}}</option>
                @endforeach
            </select>
        </div>

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
                <th>ALMACEN</th>
                <th>FOTO</th>
                <th>ACCIONES</th>

            </tr>
        </thead>

            <tbody>
                @foreach ($productosT as $producto)
                    <tr data-id="{{ $producto->id }}">
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre_producto }}</td>
                        <td>{{ $producto->unidad }}</td>
                        <td>{{ $producto->stock_minimo }}</td>
                        <td>{{ $producto->categoria->nombre_categoria }}</td>
                        <td>{{ $producto->existencias }}</td>
                        <td>{{ App\Models\Area::find($producto->area)->area_nombre }} , {{ App\Models\Almacen::find($producto->subarea)->almacen_nombre }}</td>
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
                            @can('producto.crear')
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
                            @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>            
    </div>
</div>
