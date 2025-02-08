<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes de Mermas') }}
        </h2>
    </x-slot>
    
    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-10">
        
        <div class="mx-auto sm:px-6 lg:px-8" style="width:80rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
    
                            <th>Producto_id</th>
                            <th>eid</th>
                            <th>Status</th>
                            <th>Cantidad</th>
                            <th>Reporte</th>
                            <th>Acciones</th>  
                        </tr>  
                    </thead>    
                    <tbody>
                        @foreach ($productos as $producto)
                        <tr data-id="{{ $producto->id }}">
                            <td>{{ $producto->producto_id }}</td>
                            <td>{{ $producto->eid }}</td>
                            <td>{{ $producto->status }}</td>
                            <td>{{ $producto->cantidad }}</td>
                            <td>{{ $producto->archivo }}</td>
                            <td>
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <!-- Botón Crear -->
                                    <a type="button" href="{{ route('inventario.eliminar') }}" style="text-decoration: none" class="rounded bg-blue-600 hover:bg-blue-500 text-black font-bold py-2 px-4 ml-2">Inicio</a>
                                    <!-- Botón Editar -->
                                    <form action="{{ route('prodcutos.edit', $prodcuto->id) }}" method="GET" class="rounded bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 ml-2">
                                        @csrf
                                        <input type="text" class="hidden" name="id" value="{{$dia->id}}">
                                        <button type="submit" class="text-black font-bold">Editar</button>
                                    </form>

                                    <!-- Botón Borrar -->
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="formEliminar rounded bg-red-600 hover:bg-red-700 text-black font-bold py-2 px-4 ml-2">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-black font-bold">Borrar</button>
                                    </form>
                                </div>
                            </td>
                   
                        </tr>
                        @endforeach   
                    </tbody>                   
                </table>
                <a type="button" href="{{ route('feriados.create') }}" style="background-color: rgb(21 128 61);text-decoration:none" class="rounded bg-blue-600 hover:bg-green-700 text-white font-bold py-2 px-4">Crear</a>
            </div>
        </div>
    </div>
    @section('js')
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>
    @endsection
</x-app-layout>

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form  
  var forms = document.querySelectorAll('.formEditar')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {        
          event.preventDefault()
          event.stopPropagation()        
          Swal.fire({
                title: '¿Confirmar la solicitud?',        
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire('¡Enviado!', 'La solicitud ha sido enviado exitosamente.','success');
                }else{
                    //Se oculta el loader para que no tape toda la pantalla por siempre.
                    loader.style.display = "none";
                }
            })                      
      }, false)
    })})()
</script>




