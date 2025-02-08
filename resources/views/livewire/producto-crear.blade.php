<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="formEnviar">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre del
                Producto:</label>
            <input name="nombre_prod" style="border-color: rgb(21 128 61);"
                class="py-1 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                type="text" required />
        </div>

        <div class="grid grid-cols-1">
            <label class="py-2 ml-2 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Unidad</label>
            <select name="unidad" id="unidad"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                required />

            <option id="unidad1" value="Piezas">Piezas</option>
            <option id="unidad2" value="Cajas">Cajas</option>
            <option id="unidad3" value="Paquetes">Paquetes</option>
            <option id="unidad4" value="Metros">Metros</option>
            <option id="unidad5" value="Litros">Litros</option>
            <option id="unidad6" value="Kilogramos">Kilogramos</option>
            <option id="unidad7" value="Galones">Galones</option>
            <option id="unidad8" value="Bolsa">Bolsa</option>
            <option id="unidad9" value="Block">Block</option>

            </select>
        </div>

        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Stock Mínimo:</label>
            <input name="stock_min" style="border-color: rgb(21 128 61);"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                type="number" min="0" required />
        </div>

        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Categoría:</label>
            <select name="categoria_id" id="categoria_id"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                required />
            @foreach ($categorias as $categoria)
                <option id="{{ $categoria->id }}" value="{{ $categoria->id }}">{{ $categoria->nombre_cat }}</option>
            @endforeach

            </select>
        </div>
        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                ÁREA:</label>
            <input disabled name="area" value='{{ App\Models\Area::find($area)->area_nombre }}'
                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                type="text" required />
            <input name="area" value='{{ $area }}'
                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                class="hidden py-2 px-3 rounded-lg border-2 
                border-blue-600 mt-1 focus:outline-none focus:ring-2 
                focus:ring-blue-700 focus:border-transparent"
                type="text" required />
        </div>
        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                ALMACEN:</label>
            <select name="subarea"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                required >
            @if($almacenes->count() <= 0)
                <option  value="">{{ '-No eres Jefe de ningún almacen activo-' }}</option>
            @endif
            @foreach ($almacenes as $almacen)
                <option id="{{ $almacen->id }}" value="{{ $almacen->almacen_clave }}">{{ $almacen->almacen_nombre }}
                </option>
            @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1">
            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Existencias:</label>
            <input name="existencias" style="border-color: rgb(21 128 61);"
                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                type="number" min="0" required />
        </div>

    </div>
    <div class="grid grid-cols-1 gap-5 md:gap-8 mt-5 mx-7">
        <div class='flex items-center justify-center w-full'>
            <label class='flex flex-col hover:bg-green-7000 hover:border-blue-600 group'>
                <div class='flex flex-col items-center justify-center pt-7'>
                    <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Foto
                        Producto</label>
                    <img id="photo_prod" style="max-height: 200px;max-width: 290px;min-height: 200px;min-width: 230px;"
                        class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent hover:bg-green-7000 hover:border-blue-600">
                    </p>

                    <input name="photo_prod" id="imagen" type='file' class="hidden" required />
                </div>
            </label>
        </div>
    </div>


    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
        <a href="{{ url()->previous() }}"
            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
        <!-- botón enviar -->
        <form action="{{ route('productos.index') }}" method="POST"
            class="formEnviar w-auto bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
            @csrf
            <button type="submit"
                class="w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-7 py-2">Enviar</button>
        </form>
    </div>
</form>
