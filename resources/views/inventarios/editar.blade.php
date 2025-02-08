<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle pedido N.° ') . Str::of($inventario->id) }}
        </h2>
    </x-slot>
    @section('css')
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
@endsection
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="my-4 px-4 py-3 ml-2 leading-normal text-green-500 rounded-lg" role="alert">
                        <div class="text-left">
                            <a href="{{ url()->previous() }}"
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
                    <form action="{{ route('inventarios.store') }}" method="post" id="formGuardar">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                                <input disabled name="eid" value='{{ $inventario->eid }}'
                                    style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                    class=" py-2 px-3 rounded-lg border-2 
                                    border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 
                                    focus:border-transparent"
                                    type="text" required />
                            </div>
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">NOMBRE:</label>
                                <input disabled name="nombre" value='{{ $inventario->nombre }}'
                                    style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                    class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none 
                                    focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                    type="text" required />
                            </div>
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">EMAIL:</label>
                                <input disabled name="email" value='{{ $inventario->email }}'
                                    style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                    class=" py-2 px-3 rounded-lg border-2 
                                    border-blue-600 mt-1 focus:outline-none focus:ring-2 
                                    focus:ring-blue-700 focus:border-transparent"
                                    type="text" required />
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                    ALMACEN AL QUE SE LE SOLICITA:</label>
                                @if(App\Models\Almacen::find($inventario->almacen))
                                    <input disabled name="" value='{{ App\Models\Almacen::find($inventario->almacen)->almacen_nombre }}'
                                        style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                        class=" py-2 px-3 rounded-lg border-2 
                                        border-blue-600 mt-1 focus:outline-none focus:ring-2 
                                        focus:ring-blue-700 focus:border-transparent"
                                        type="text" required />
                                @else
                                    <input disabled name="" value='{{ App\Models\Subarea::find($inventario->almacen)->subarea_nombre }}'
                                        style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                        class=" py-2 px-3 rounded-lg border-2 
                                        border-blue-600 mt-1 focus:outline-none focus:ring-2 
                                        focus:ring-blue-700 focus:border-transparent"
                                        type="text" required />
                                @endif
                            </div>
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO DE
                                    TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <input disabled name="" value='{{ App\Models\Subarea::find($inventario->subarea)->subarea_nombre }}'
                                    style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                    class=" py-2 px-3 rounded-lg border-2 
                                        border-blue-600 mt-1 focus:outline-none focus:ring-2 
                                        focus:ring-blue-700 focus:border-transparent"
                                    type="text" required />
                            </div>
                        </div>
                    </form>

                    <div class="mt-2">
                        <div>
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                                    style="padding-left: 2em; padding-right: 2em;">
                                    <table id="data-table" class="stripe hover translate-table"
                                        style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                        <thead>
                                            <tr data-id="{{ $inventario->id }}">

                                                <th>NOMBRE DEL PRODUCTO</th>
                                                <th>CANTIDAD PEDIDA</th>
                                                <th>CANTIDAD AUTORIZADA</th>
                                                <th>FOTO</th>
                                                <th>STATUS</th>
                                                <th>NOTA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productos as $producto)
                                                @if($producto->id != "esp")
                                                    <tr data-id="{{ $producto->id }}">
                                                        <td>{{ $producto->name }}</td>
                                                        <td>{{ $producto->qty }}</td>
                                                        <td>
                                                            @if($producto->options->status == 'Rechazado')
                                                                0
                                                            @else
                                                                {{ $producto->options->qtyAuth }}
                                                            @endif
                                                        </td>
                                                        <td class="px-14 py-1">
                                                            @if ( $productosInfo[$producto->id]->photo_prod != null)
                                                                <img src="{{ asset('imagen_productos/' . $productosInfo[$producto->id]->photo_prod) }}"
                                                                    width="50px" alt="Foto del producto">
                                                            @else
                                                                <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                                                    width="50ppx" id="imagenSeleccionada"
                                                                    alt="Foto actual del producto">
                                                            @endif
                                                        </td>
                                                        <td>{{ $producto->options->status }}</td>
                                                        <td>
                                                            <div>
                                                                @if(isset($producto->options->justificacion))
                                                                    {{$producto->options->justificacion}}
                                                                @else
                                                                    Sin comentarios
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--
                                    <label style="font-weight:800; font-size:15px" >PEDIDOS ESPECIALES</label>
                                    <table id="data-table" class="stripe hover translate-table"
                                        style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                        <thead>
                                            <tr data-id="{ { $inventario->id }}">
                                                <th>NOMBRE DEL PRODUCTO</th>
                                                <th>DESCRIPCION DEL PRODUCTO</th>
                                                <th>JUSTIFICACION</th>
                                                <th>CANTIDAD PEDIDA</th>
                                                <th>CANTIDAD AUTORIZADA</th>
                                                <th>NIVEL</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @ foreach ($productos as $producto)
                                                @ if($producto->id == "esp")
                                                    <tr data-id="{ { $producto->id }}">
                                                        <td>{ { $producto->name }}</td>
                                                        <td>{ { $producto->options->descripcion }}</td>
                                                        <td>{ { $producto->options->justificacion }}</td>
                                                        <td>{ { $producto->qty }}</td>
                                                        <td>@ if($producto->options->status == 'Rechazado')
                                                            0
                                                        @ else
                                                            { { $producto->options->qtyAuth }}
                                                        @ endif
                                                    </td>
                                                        <td>{ { $producto->options->import }}</td>
                                                        <td>{ { $producto->options->status }}</td>
                                                    </tr>
                                                @ endif
                                            @ endforeach
                                        </tbody>
                                    </table>
                                -->
                                </div>
                                {{-- @livewire('inventarios-table') --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.openModal').on('click', function(e) {
                    $('#interestModal').removeClass('invisible');
                });
                $('.closeModal').on('click', function(e) {
                    $('#interestModal').addClass('invisible');
                });
                const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
                var SITEURL = "{{ url('/') }}";
                <?php foreach ($productos as $producto) { ?>
                $("#formAgregar{{ $producto->id }}").submit(function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Seguro que quieres agregarlo al carrito?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formAgregar{{ $producto->id }}').submit();
                        }
                    });
                });
                $("#formCantidad{{ $producto->id }}").submit(function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Seguro que quieres cambiar la cantidad?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formCantidad{{ $producto->id }}').submit();
                        }
                    });
                });
                $("#formEliminar{{ $producto->id }}").submit(function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Seguro que quieres eliminarlo del carrito?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Eliminado con exito!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            }).then((result) => {
                                document.getElementById('formEliminar{{ $producto->id }}')
                                    .submit();
                            });
                        }
                        //Se oculta el loader para que no tape toda la pantalla por siempre.
                        else{
                            loader.style.display = "none";
                        }
                    });
                });
                <?php } ?>
            });
        </script>

        <script>
            function guardarInventario() {
                <?php if (\Gloudemans\Shoppingcart\Facades\Cart::content()->count() === 0) : ?>
                Swal.fire({
                    title: '¡No hay productos en el carrito!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                })
                <?php else : ?>
                Swal.fire({
                    title: '¡Guardado con exito!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    document.getElementById('formGuardar').submit();
                })
                <?php endif; ?>
            }
        </script>
    @endsection

</x-app-layout>
