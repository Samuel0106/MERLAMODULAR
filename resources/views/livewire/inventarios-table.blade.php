<table id="data-table" class="stripe hover translate-table" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
    <thead>
        <tr>

            <th>NOMBRE DEL PRODUCTO</th>
            <th>TIPO DE UNIDAD</th>
            <th>CATEGORIA</th>
            <th>EXISTENCIAS</th>
            <th>FOTO</th>
            <th>ACCIONES</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($productosA as $producto)
            <tr data-id="{{ $producto->id }}">
                <td>{{ $producto->nombre_prod }}</td>
                <td>{{ $producto->unidad }}</td>
                <td>{{ $producto->categoria->nombre_cat }}</td>
                <td>{{ $producto->existencias }}</td>
                <td>
                    @if ($producto->photo_prod != null)
                        <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} " width="50ppx"
                            id="imagenSeleccionada" alt="Foto actual del producto">
                    @else
                        <img src="{{ asset('imagen_productos/iconProduct.png') }}" width="50ppx" id="imagenSeleccionada"
                            alt="Foto actual del producto">
                    @endif

                </td>

                <td class="border-l px-4 py-2">
                    @if ($producto->existencias > 0)
                        <div class="justify-center rounded-lg text-lg inline-flex">
                            @if ($carro->where('id', $producto->id)->count())
                                <form action="{{ route('cart.update') }}" method="POST" enctype="multipart/form-data"
                                    id="formCantidad{{ $producto->id }}"
                                    class="place-content-center inline-flex rounded">
                                    @csrf
                                    <div>
                                        <input type="hidden" name="row"
                                            value="{{ $carro->where('id', $producto->id) }}" />
                                        <input type="number" name="cantidad" placeholder="Cantidad"
                                            class="rounded-lg text-sm sm:test-base ml-4 pr-4 w-2/3"
                                            value="{{ $carro[$producto->id]->qty }}" min="1" required />
                                    </div>
                                    <div class="rounded bg-blue-600 hover:bg-blue-700 mr-4">
                                        <button type="submit"
                                            class="rounded text-white font-bold py-1 px-1 inline-flex">Cambiar
                                            cantidad
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="pr-2 h-7 w-7 place-self-center" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                <!-- botón borrar -->
                                <form action="{{ route('cart.destroy') }}" method="POST"
                                    id="formEliminar{{ $producto->id }}">
                                    @csrf
                                    <input type="hidden" name="row"
                                        value="{{ $carro->where('id', $producto->id) }}" />
                                    <div class="rounded bg-red-600 hover:bg-red-600 mr-4">
                                        <button type="submit"
                                            class="rounded  text-white font-bold py-1 px-1 inline-flex">Borrar
                                            del carrito
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="pr-2 h-7 w-7 place-self-center" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <!-- botón agregar al carrito -->
                                <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data"
                                    id="formAgregar{{ $producto->id }}"
                                    class="place-content-center inline-flex rounded">
                                    @csrf
                                    <div>
                                        <input type="hidden" name="producto_id" value="{{ $producto->id }}" />
                                        <input type="number" name="cantidad" placeholder="Cantidad"
                                            class="rounded-lg text-sm sm:test-base ml-4 pr-4 w-6/12" min="1"
                                            required />
                                        <input type="hidden" name="subareaDestino" wire:model="subDestino" />
                                    </div>
                                    <div class="rounded bg-blue-500 hover:bg-green-700">
                                        <button type="submit"
                                            class="rounded text-white font-bold py-1 px-1 inline-flex w-11/12">Agregar
                                            al carrito
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="pl-2 h-7 w-7 place-self-center" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="justify-center rounded-lg text-lg inline-flex">
                            No hay existencias de este producto por el momento.
                        </div>
                    @endif
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
