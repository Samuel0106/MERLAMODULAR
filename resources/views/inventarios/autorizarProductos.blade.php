<x-app-layout>
    <style>
        /* Estilos para el modal de foto de entrega */
        .modalFoto, .modalCorreo, .modalVerificacion {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #111111bd; /* "bd" deja el fondo casi transparente */
            display: flex;
            opacity: 0; /* Hace que no se vea el modal */
            pointer-events: none;   /* Evita que el mouse pueda detectar o activar cualquier cosa dentro del modal.*/
            transition: opacity .6s;
        }
        .modalF_container, .modalC_container, .modalV_container {
            margin: auto;
            width 90%;
            max-width: 600px;
            min-width: 300px;
            background-color: white;
            border-radius: 6px;
            padding: 3em 2.5em;
            display: grid;
            gap: 1em;
            place-items: center;
            grid-auto-columns: 100%;
        }
        .modalShow {
            opacity: 1;
            pointer-events: unset;
            transition: opacity .6s;
        }

    </style>

    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($inventario->status == 'Autorizado')
                {{ __('Entregar productos del Pedido N.°' . Str::of($inventario->id)) }}
            @else
                {{ __('Autorizar productos del Pedido N.°' . Str::of($inventario->id)) }}
            @endif

        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <?php 
        $total = true;
    ?>
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
            @elseif (session()->has('success'))
                <div class="px-2 inline-flex flex-row" id="mssg-status">
                    {{ session()->get('success') }}
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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <div class="my-4 px-3 py-3  leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                    @if ($inventario->status == 'Autorizado')
                        <a href="{{ route('inventarios.entregar') }}"
                            class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                    @else
                        <a href="{{ route('inventarios.autorizar') }}"
                            class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                    @endif
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
                    style="width:97%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>CANTIDAD</th>
                            <th>CANTIDAD AUTORIZADA</th>
                            <th>CANTIDAD DISPONIBLE</th>
                            <th>FOTO</th>
                            <th>STATUS</th>
                            <th>ACCIONES</th>
                            <th>NOTA</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            @if ($producto->id != "esp")
                            <tr data-id="{{ $inventario->id }}">
                                <td>{{ $producto->name }}</td>
                                <td>{{ $producto->qty }}</td>
                                <td>{{ $producto->options->qtyAuth; }}</td>
                                {{-- <td>{{App\Models\Producto::where('id', $producto->id)->first()->existencias}}</td> --}}
                                <td>{{ isset($existencias[$producto->id]) ? $existencias[$producto->id] : '0' }}</td>
                                <td class="px-14 py-1">
                                    @if (isset($productosInfo[$producto->id]) && $productosInfo[$producto->id]->photo_prod != null)
                                        <img src="{{ asset('imagen_productos/' . $productosInfo[$producto->id]->photo_prod) }} "
                                            width="50ppx" alt="Foto del producto">
                                    @else
                                        <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                            width="50ppx" id="imagenSeleccionada" alt="Foto actual del producto">
                                    @endif
                                </td>
                                <td>{{ $producto->options->status }}</td>
                                <!--Acciones-->
                                <td class="border-l px-4 py-2">
                                    <div class="justify-center rounded-lg text-lg inline-flex">
                                        @if ($inventario->status == 'Pendiente')
                                            @can('inventario.autorizar')
                                                @if ($producto->options->status == 'Pendiente')<!--Si hay productos pendientes-->

                                                    <!-- botón autorizar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="formAutorizar place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div style="width: 100px">
                                                            @if(App\Models\Producto::where('id', $producto->id)->first()->existencias>0)
                                                            <input type="number" name="cantAuth"
                                                                placeholder="Cantidad a Autorizar"
                                                                class="rounded-lg text-sm sm:test-base "
                                                                min=1
                                                                max={{/*App\Models\Producto::where('id', $producto->id)->first()->existencias < $producto->qty ? App\Models\Producto::where('id', $producto->id)->first()->existencias : $producto->qty;*/
                                                                        App\Models\Producto::where('id', $producto->id)->first()->existencias}}
                                                                required />
                                                            @else
                                                                Sin existencias
                                                            @endif
                                                        </div>
                                                        @if(App\Models\Producto::where('id', $producto->id)->first()->existencias>0)
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Autorizar
                                                                Producto</button>
                                                        </div>
                                                        @endif
                                                    </form>
                                                    <!-- botón rechazar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">Rechazar
                                                            Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Autorizado parcialmente')<!--Si tienen autorización parcial-->
                                                    <!-- botón Autorizar -->
                                                    {{-- <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div style="width: 100px">
                                                            <input type="number" name="cantAuth"
                                                                placeholder="Cantidad a Autorizar"
                                                                class="rounded-lg text-sm sm:test-base "
                                                                min=1 
                                                                max={{ //App\Models\Producto::where('id', $producto->id)->first()->existencias < $producto->qty ? App\Models\Producto::where('id', $producto->id)->first()->existencias : $producto->qty
                                                                        App\Models\Producto::where('id', $producto->id)->first()->existencias}} 
                                                                required />
                                                        </div>
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Autorizar
                                                                Producto</button>
                                                        </div>
                                                    </form> --}}
                                                    <!-- botón rechazar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">Rechazar
                                                            Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Autorizado') <!--Si ya fue autorizado-->
                                                    <!-- botón rechazar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">Rechazar
                                                            Producto</button>
                                                    </form>

                                                @else
                                                    <!-- botón autorizar -->
                                                    <form @if(App\Models\Producto::where('id', $producto->id)->first()->existencias<=0)
                                                            hidden
                                                        @endif
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div style="width: 100px">
                                                            <input type="number" name="cantAuth"
                                                                placeholder="Cantidad a Autorizar"
                                                                class="rounded-lg text-sm sm:test-base "
                                                                min=1 
                                                                max={{ //App\Models\Producto::where('id', $producto->id)->first()->existencias < $producto->qty ? App\Models\Producto::where('id', $producto->id)->first()->existencias : $producto->qty
                                                                        App\Models\Producto::where('id', $producto->id)->first()->existencias}} 
                                                                required />
                                                        </div>
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Autorizar
                                                                Producto
                                                            </button>
                                                        </div>
                                                    </form>
                                                    @if(App\Models\Producto::where('id', $producto->id)->first()->existencias<=0)
                                                        Sin existencias
                                                    @endif
                                                @endif
                                            @endcan
                                        @elseif ($inventario->status == 'Autorizado')
                                            @can('inventario.entregar')
                                                @if ($producto->options->status == 'Autorizado')
                                                <?php $total = false ?>
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Entregar
                                                                Producto</button>
                                                        </div>
                                                    </form>
                                                    <!-- botón no entregado -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'No entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">No
                                                            entregar Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Entregado')
                                                    <!-- botón no entregado -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'No entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">No
                                                            entregar Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Rechazado')
                                                        <div>Producto Rechazado</div>
                                                @else
                                                    <!-- botón entregar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Entregar
                                                                Producto</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @can('inventario.autorizar')
                                    <form action="{{ route('inventarios.comentario', ['inventario' => $inventario->id, 'id' => $producto->id]) }}"
                                        method="PUT" enctype="multipart/form-data"
                                        class="place-content-center inline-flex rounded text-black">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <input type="text" name="comentario"
                                                @if(isset($producto->options->justificacion))
                                                value="{{$producto->options->justificacion}}"
                                                @else
                                                placeholder="{{"comentario"}}"
                                                @endif
                                                class="rounded-lg text-sm sm:test-base mr-3"/>
                                        </div>
                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                            <button type="submit"
                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Subir
                                            </button>
                                        </div>
                                    </form>
                                    @endcan
                                </td>
                            </tr>

                            @endif
                        @endforeach

                        @foreach ($productos as $producto)
                            @if ($producto->id == "esp")
                            <tr data-id="{{ $inventario->id }}">
                                <td>{{ $producto->name }}</td>
                                <td>{{ $producto->qty }}</td>
                                <td>{{ $producto->options->status }}</td>
                                <td class="border-l px-4 py-2">
                                    <div class="justify-center rounded-lg text-lg inline-flex">
                                        @if ($inventario->status == 'Pendiente')
                                            @can('inventario.autorizar')
                                                @if ($producto->options->status == 'Pendiente')
                                                    <!-- botón autorizar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="formAutorizar place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div style="width: 100px">
                                                            <input type="number" name="cantAuth"
                                                                placeholder="Cantidad a Autorizar"
                                                                class="rounded-lg text-sm sm:test-base "
                                                                min=1 max={{$producto->qty}} required />
                                                        </div>
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Autorizar
                                                                Producto</button>
                                                        </div>
                                                    </form>
                                                    <!-- botón rechazar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">Rechazar
                                                            Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Autorizacion Parcial')
                                                    <!-- botón Autorizar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div style="width: 100px">
                                                            <input type="number" name="cantAuth"
                                                                placeholder="Cantidad a Autorizar"
                                                                class="rounded-lg text-sm sm:test-base "
                                                                min=1 max={{$producto->qty}} required />
                                                        </div>
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Autorizar
                                                                Producto</button>
                                                        </div>
                                                    </form>
                                                    <!-- botón rechazar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">Rechazar
                                                            Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Autorizado')
                                                <!-- botón rechazar -->
                                                <form
                                                    action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado', 'id' => $producto->id]) }}"
                                                    method="PUT" enctype="multipart/form-data"
                                                    class="place-content-center inline-flex rounded text-black">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">Rechazar
                                                        Producto</button>
                                                </form>

                                                @else
                                                    <!-- botón autorizar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div style="width: 100px">
                                                            <input type="number" name="cantAuth"
                                                                placeholder="Cantidad a Autorizar"
                                                                class="rounded-lg text-sm sm:test-base"
                                                                min=1 max={{$producto->qty}} required />
                                                        </div>
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Autorizar
                                                                Producto
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endcan
                                        @elseif ($inventario->status == 'Autorizado')
                                            @can('inventario.entregar')
                                                @if ($producto->options->status == 'Autorizado')
                                                    <div>Producto Autorizado</div>
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Entregar
                                                                Producto</button>
                                                        </div>
                                                    </form>
                                                    <!-- botón no entregado -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'No entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">No
                                                            entregar Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Entregado')
                                                    <!-- botón no entregado -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'No entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="rounded bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 mr-4 inline-flex">No
                                                            entregar Producto</button>
                                                    </form>
                                                @elseif($producto->options->status == 'Rechazado')
                                                        <div>Producto Rechazado</div>
                                                @else
                                                    <!-- botón entregar -->
                                                    <form
                                                        action="{{ route('inventarios.changeProductStatus', ['inventario' => $inventario->id, 'status' => 'Entregado', 'id' => $producto->id]) }}"
                                                        method="PUT" enctype="multipart/form-data"
                                                        class="place-content-center inline-flex rounded text-black">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                                            <button type="submit"
                                                                class="rounded text-white font-bold py-1 px-2 inline-flex">Entregar
                                                                Producto</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!--
                <div>
                    <div>
                        <label class="uppercase md:text-sm font-semibold">
                            Comentarios:
                        </label>
                    </div>

                    <input
                        style="width: 100%"
                        id="comentario"
                        name="comentario"
                        type="text"
                        class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"/>
                </div> -->
                <div class="float-left rounded-lg text-lg inline-flex gap-4 my-4">
                    @if ($inventario->status == 'Pendiente')
                        <div class="grid place-content-center mt-1">
                            <a type="button"
                                href="{{ route('inventarios.changeInventarioStatus', ['inventario' => $inventario->id, 'status' => 'Autorizado']) }}"
                                class="invSubmit bg-blue-500 px-12 py-2 rounded text-white font-semibold hover:bg-blue-600 transition duration-200 each-in-out">
                                Pasar a autorizar</a>
                        </div>
                        <div class="grid place-content-center mt-1">
                            <a type="button"
                                href="{{ route('inventarios.changeInventarioStatus', ['inventario' => $inventario->id, 'status' => 'Rechazado' ]) }}"
                                class="invSubmit bg-red-600 px-12 py-2 rounded text-white font-semibold hover:bg-red-700 transition duration-200 each-in-out">
                                Rechazar Pedido</a>
                        </div>
                    @elseif ($inventario->status == 'Autorizado')
                        @if($total)
                            <div class="grid place-content-center mt-1">
                                <a type="button"
                                    href="{{ route('inventarios.changeInventarioStatus', ['inventario' => $inventario->id, 'status' => 'Entregado']) }}"
                                    class="invEntrega bg-blue-500 px-12 py-2 rounded text-white font-semibold hover:bg-blue-600 transition duration-200 each-in-out">
                                    Pasar a entregar</a>
                            </div>
                        @endif
                        <div class="grid place-content-center mt-1">
                            <a type="button" href="{{ route('inventarios.changeInventarioStatus', ['inventario' => $inventario->id, 'status' => 'No entregado']) }}" class="bg-red-600 px-12 py-2 rounded text-white font-semibold hover:bg-red-700 transition duration-200 each-in-out">
                                No entregar Pedido</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal para agregar el código de verificacion -->
        <section class="modalVerificacion">
            <div class="modalV_container">
                <form id="formCode" action="{{route('inventarioEmails.verificarCodigo')}}">
                <div class='flex items-center justify-center w-full'>
                    <label class='flex flex-col hover:bg-green-7000 hover:border-blue-600 group'>
                        <div class='flex flex-col items-center justify-center pt-7'>
                        <h2 class="font-medium text-black">Codigo de Verificación</h2>
                            <input name="codigo" id="codigo" type='text' minlength="4" maxlength="4" style="width: 50%" value="1234" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                            <input hidden name="folio" id="folio" type='number' value="{{$inventario->id}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                        </div>
                    </label>
                </div>
                <p class="font-medium text-black">Ingresa el código de verificacion<br>que se envió al correo.</p>
                <div class='flex items-center justify-center'>
                    <!-- botón cancelar -->
                    <button class='cancelarVButton mx-2 bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</button>
                    <!-- botón enviar -->
                    <button type="submit" class="bg-blue-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                    </div>
                </form>
            </div>
        </section>


        <!-- Modal para subir la foto de la entrega -->
        <section class="modalFoto">
            <div class="modalF_container">
                <form id="formFoto" action="{{route('inventarioEmails.addFoto')}}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class='flex items-center justify-center w-full'>
                    <label class='flex flex-col hover:bg-green-7000 hover:border-blue-600 group'>
                        <div class='flex flex-col items-center justify-center pt-7'>
                        <h2 class="font-medium text-black">Foto Entrega</h2>
                        <img id="imagenSeleccionada" style="max-height: 200px;max-width: 290px;min-height: 200px;min-width: 290px;"  class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent hover:bg-green-7000 hover:border-blue-600">
                        <input name="foto" id="imagen" type='file' class="hidden" required/>
                        <input hidden name="folio" id="folio" type='number' value="{{$inventario->id}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                        </div>
                    </label>
                </div>
                <p class="font-medium text-black">Selecciona la foto correspondiente a la entrega</p>
                <div class='flex items-center justify-center'>
                    <!-- botón cancelar -->
                    <button class='cancelarFButton mx-2 bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</button>
                    <!-- botón enviar -->
                    <button type="submit" class="bg-blue-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                </div>
                </form>
            </div>
        </section>
    </div>

    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
</x-app-layout>

<script>
    // $(document).ready(function() {
    //     //Para mostrar el modal.
    //     $('.invEntrega').on('click', function(e) { //al dar click en el botón Entregar Pedido.
    //         e.preventDefault(); //Se evita el comportamiento por default.
    //         //Si ya paso el codigo de verificacion
    //         @if (session()->has('success'))
    //         $('.modalFoto').addClass('modalShow');
    //         //Para ocultar el modal de la foto.
    //         $('.cancelarFButton').on('click', function(e) {
    //             e.preventDefault();
    //             $('.modalFoto').removeClass('modalShow');

    //         });
    //         //Si apenas lo pondra
    //         @else
    //         $('.modalVerificacion').addClass('modalShow');  //Se agrega la clase modalShow que hace que se muestre el modal.
    //         @endif
    //     });
    //     //Para ocultar el modal del Codigo de Verificación.
    //     $('.cancelarVButton').on('click', function(e) {
    //         e.preventDefault();
    //         $('.modalVerificacion').removeClass('modalShow');
    //     });
    //     $('#imagen').change(function(){ //Carga la imagen al seleccionarla.
    //         let reader = new FileReader();
    //         reader.onload = (e) => {
    //             $('#imagenSeleccionada').attr('src', e.target.result);
    //         }
    //     reader.readAsDataURL(this.files[0]);
    //     });
    //     $("#formCode").submit(function(event) {
    //         event.preventDefault();
    //         const valor = document.getElementById("codigo").value;
    //         <?php $codigo = "<script>document.write(valor)</script>" ?>
    //         const folio = document.getElementById("folio").value;
    //         <?php $folio = "<script>document.write(folio)</script>" ?>
    //         document.getElementById('formCode').action.value = "{{route('inventarioEmails.verificarCodigo',['codigo' => <?php $codigo ?>,'folio' => <?php $folio ?>])}}";
    //         document.getElementById('formCode').submit();
    //     });
    // });
</script>
