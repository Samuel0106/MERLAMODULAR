<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos proximos a agotar: ' . $area ) }}
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
                {{-- <div class="col-sm-12">
                    @if($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                        {{ $mensaje }}
                        </div>
                    @elseif ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div> --}}
                <br>

                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>

                            <th>NOMBRE DEL PRODUCTO</th>
                            <th>TIPO DE UNIDAD</th>
                            <th>EXISTENCIAS</th>
                            <th>STOCK MINIMO</th>
                            <th>FOTO</th>
                            <th>ACCIONES</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)

                            @if ($producto->stock_minimo > 1 ) {{-- Mostrar solo los productos que tengan mas de 1 de stock  --}}
                            
                                <!--muestra los productos que esten proximos a agotar-->
                                <tr>
                                    <td class="px-6 py-4 text-center">
                                        <div>
                                            {{ $producto->nombre_producto }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div>
                                            {{ $producto->unidad }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div>
                                            {{ $producto->existencias }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div>
                                            {{ $producto->stock_minimo }}
                                        </div>
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
                                        {{-- <div class="rounded bg-blue-500 hover:bg-blue-600 mr-4">
                                            <button type="button"
                                                class="rounded text-white font-bold py-1 px-2 inline-flex"><a href="{{ route('productos.editI', $producto->id) }}">Agregar existencias</a>
                                            </button>
                                        </div> --}}

                                        <a href="{{ route('productos.editI', $producto->id) }}" style="text-decoration:none;"
                                            class="rounded bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mx-2 ml-2">Agregar</a>
                                    </td>
                                </tr>
                            @endif
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

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form  
  var loader = document.getElementById("preloader");
  var forms = document.querySelectorAll('.formEnviar')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {        
          event.preventDefault()
          event.stopPropagation()        
          Swal.fire({
                title: '¿Confirmar el envio?',        
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire('¡Enviado!', 'El registro ha sido enviado exitosamente.','success');
                }
                else {
                    //Se oculta el loader para que no tape toda la pantalla por siempre.
                    loader.style.display = "none";
                }
                
            })                      
      }, false)
    })})()
</script>