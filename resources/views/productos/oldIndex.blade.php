<!-- <x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="mx-auto sm:px-6 lg:px-8" style="width:90rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
             
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                         
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">NOMBRE DEL PRODUCTO</th>
                            <th class="border px-4 py-2">TIPO DE UNIDAD</th>
                            <th class="border px-4 py-2">STOCK MINIMO</th>
                            <th class="border px-4 py-2">CATEGORIA</th>
                            <th class="border px-4 py-2">FOTO</th>
                            <th class="border px-4 py-2">ACCIONES</th>
                            
                        </tr>  
                    </thead>    
                    <tbody>
                        @foreach ($productos as $producto)
                        <tr>
                            <td style="display: none;">{{$producto->id}}</td>
                            
                            <td>{{$producto->id}}</td>
                            <td>{{$producto->nombre_prod}}</td>
                            <td>{{$producto->unidad}}</td>
                            <td>{{$producto->stock_min}}</td>
                            <td>{{$producto->categoria}}</td>
                            <td  class="px-14 py-1">
                                <img src="/imagen_productos/{{$producto->photo_prod}}" alt="Foto del producto" width="80%">
                            </td> 
                             
                            <td class="border-l px-4 py-2">
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    botón editar
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="rounded bg-yellow-400 hover:bg-yellow-400 text-white font-bold py-2 px-4 mx-2">Editar</a>
    
                                    botón borrar
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="rounded formEliminar bg-red-400 hover:bg-red-600">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded text-black font-bold py-2 px-4 mx-1">Borrar</button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @endforeach   
                    </tbody>  
                         
                </table>   
                <div class="mt-2">
                    {!! $productos->links() !!}
                </div>
                <div class="grid place-content-end mt-4">
                    <a type="button" href="{{ route('productos.create') }}"  class="bg-indigo-500 px-12 py-2 rounded text-white font-semibold hover:bg-indigo-800 transition duration-200 each-in-out"> Crear</a>
                </div>
                



            </div>
        </div>
    </div>
</x-app-layout>

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form  
  var forms = document.querySelectorAll('.formEliminar')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {        
          event.preventDefault()
          event.stopPropagation()        
          Swal.fire({
                title: '¿Confirma la eliminación del registro?',        
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire('¡Eliminado!', 'El registro ha sido eliminado exitosamente.','success');
                }
            })                      
      }, false)
    })

})()
</script> -->