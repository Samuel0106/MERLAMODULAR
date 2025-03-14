<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto: ') . Str::of($producto->nombre_producto) }}
        </h2>
    </x-slot>
    <style>
        .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        }
        
        .alert-danger {
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
        }
        
        .alert-success {
        background-color: #dff0d8;
        border-color: #d6e9c6;
        color: #3c763d;
        }
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-6 px-4 py-3 ml-3 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ route('productos.index') }}"
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
                <form action="{{ route('productos.update', $producto) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="col-sm-12">
                            @if($mensaje = Session::get('success'))
                                <div class="alert alert-success" role="alert">
                                {{ $mensaje }}
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-12">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre
                                del
                                producto:</label>
                            <input name="nombre_producto" value="{{ $producto->nombre_producto }}"
                                class="py-1 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            <small class="text-gray-400">Nombre actual: {{ $producto->nombre_producto }}</small>
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="py-2 ml-2 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Unidad</label>
                            <select name="unidad" id="unidad"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                required />

                            <option id="unidad1" value="Piezas" {{ $producto->unidad == 'Piezas' ? 'selected' : '' }}>
                                Piezas</option>
                            <option id="unidad2" value="Cajas" {{ $producto->unidad == 'Cajas' ? 'selected' : '' }}>
                                Cajas</option>
                            <option id="unidad3" value="Paquetes"
                                {{ $producto->unidad == 'Paquetes' ? 'selected' : '' }}>Paquetes</option>
                            <option id="unidad4" value="Metros" {{ $producto->unidad == 'Metros' ? 'selected' : '' }}>
                                Metros</option>
                            <option id="unidad5" value="Litros" {{ $producto->unidad == 'Litros' ? 'selected' : '' }}>
                                Litros</option>
                            <option id="unidad6" value="Kilogramos"
                                {{ $producto->unidad == 'Kilogramos' ? 'selected' : '' }}>Kilogramos</option>
                            <option id="unidad7" value="Galones"
                                {{ $producto->unidad == 'Galones' ? 'selected' : '' }}>Galones</option>
                            <option id="unidad8" value="Bolsa" {{ $producto->unidad == 'Bolsa' ? 'selected' : '' }}>
                                Bolsa</option>
                            <option id="unidad9" value="Block" {{ $producto->unidad == 'Block' ? 'selected' : '' }}>
                                Block</option>

                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Stock
                                Mínimo:</label>
                            <input name="stock_minimo" value="{{ $producto->stock_minimo }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="number" min="0" required />
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Categoría:</label>
                            <select name="id_categoria" id="id_categoria"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                required />
                            @foreach ($categorias as $categoria)
                                <option id="{{ $categoria->id }}" value="{{ $categoria->id }}"
                                    {{ $producto->id_categoria == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}</option>
                            @endforeach

                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA:</label>
                            <input disabled name="area"
                                value='{{ App\Models\Area::find($producto->area)->area_nombre }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            <input hidden name="area" value="{{ $producto->area }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ALMACEN:</label>
                                @if(App\Models\Almacen::find($producto->subarea))
                                    <input disabled name="subarea"
                                    value='{{ App\Models\Almacen::find($producto->subarea)->almacen_nombre }}'
                                    style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                    type="text" required />
                                @else
                                    <input disabled name="subarea"
                                    value='{{ App\Models\Subarea::find($producto->subarea)->subarea_nombre }}'
                                    style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                    type="text" required />
                                @endif
                            
                            <input hidden name="subarea" value="{{ $producto->subarea }}"
                                class="py-2 px-4 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>



                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Existencias:</label>
                            <input name="existencias" value="{{ $producto->existencias }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="number" min="0" required />
                        </div>
                    </div>
                    
                    <div class="mt-10 flex items-center justify-center px-6">
                        <div class="items-center justify-center">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold pl-10">Foto actual
                                del producto:</label>
                            <div class='flex h-72 w-72'>
                                @if ($producto->photo_prod != null)
                                    <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} " width="200ppx"
                                        id="imagenSeleccionada" alt="Foto actual del producto"
                                        class="flex flex-col border-4 border-dashed w-full h-full border-green-300">
                                @else
                                    <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                        width="200ppx" id="imagenSeleccionada" alt="Foto actual del producto"
                                        class="flex flex-col border-4 border-dashed w-full h-full border-green-300">
                                @endif
                            </div>
                        </div>

                        <div class="md:w-1/4"></div>
                        

                        <div class="items-center justify-center">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold pl-24">Subir
                                Imagen</label>
                            <div class='flex items-center justify-center w-72 h-72'>
                                <label
                                    class='flex flex-col border-4 border-dashed w-full h-full hover:bg-gray-100 hover:border-green-300 group'>
                                    <div class='flex flex-col items-center justify-center pt-24'>
                                        <svg class="w-10 h-10 text-green-400 group-hover:text-green-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p
                                            class='lowercase text-sm text-gray-400 group-hover:text-green-600 pt-1 tracking-wider'>
                                            Seleccione la imagen</p>
                                    </div>
                                    <input name="photo_prod" id="imagen" type='file' class="hidden"
                                        value="{{ asset('imagen_productos/' . $producto->photo_prod) }}" />
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('productos.index') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit" id="botonGuardar"
                            class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
<script>
    $(document).ready(function(e) {
        $('#imagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
    document.getElementById('_areas').addEventListener('change', (e) => {
        fetch(SITEURL + '/subarea', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].subarea_clave + '">' + data.lista[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("_subareas").innerHTML = opciones;
        }).catch(error => alert(error));
    })

    document.getElementById('_divisiones').addEventListener('change', (e) => {
        fetch(SITEURL + '/areas', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            var opciones1 = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].area_clave + '">' + data.lista[i]
                    .area_nombre + '</option>';
            }
            for (let i in data.listaSub) {
                opciones1 += '<option value="' + data.listaSub[i].subarea_clave + '">' + data.listaSub[
                    i].subarea_nombre + '</option>';
            }
            document.getElementById("_areas").innerHTML = opciones;
            document.getElementById("_subareas").innerHTML = opciones1;
        }).catch(error => alert(error));
    })
</script>
