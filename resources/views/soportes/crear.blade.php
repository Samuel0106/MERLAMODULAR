<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Soporte') }}
        </h2>
    </x-slot>
    <style>
        /* CHECKBOX TOGGLE SWITCH */
        /* @apply rules for documentation, these do not work as inline style */
        .toggle-checkbox:checked {
          @apply: right-0 border-blue-600;
          right: 0;
          border-color: #68D391;
        }
        .toggle-checkbox:checked + .toggle-label {
          @apply: bg-green-400;
          background-color: #68D391;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
            <form action="{{ route('soportes.store') }}" method="POST" enctype="multipart/form-data" class="formEnviar">
            @csrf


            <div class="grid grid-cols-1 md:grid-cols-1 gap-5 md:gap-8 mt-5 mx-7">

            <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Comparte tus dudas o comentarios, el timepo de respuesta es de 24 horas</label>
                      
                    </div>

            </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">TITULO:</label>
                        <input name="titulo" style="border-color: rgb(21 128 61);" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required/>
                    </div>

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">DESCRIPCION DETALLADA DE SU COMENTARIO O DUDA:</label>
                        <input name="descripcion" style="border-color: rgb(21 128 61);" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required/>
                    
                        <!-- Estos dos inputs estan aqui porque no se los mostramos al usuario pero si las mandamos a la base de datos -->
                        <input name="fecha" id="fecha" style="border-color: rgb(21 128 61);background-color: grey;" class="hidden py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="date" required/>
                        <input name="eid" value='{{$datos->eid}}' style="border-color: rgb(21 128 61);background-color: grey;" class="hidden py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required/>
                    
                    </div>
                    
                    <div class="grid grid-cols-1">
                    </div>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('dashboard') }}" class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <!-- botón enviar -->
                        <form action="{{ route('dashboard') }}" method="POST" class="formEnviar w-auto bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
                            <button type="submit" style="background-color: rgb(21 128 61);" class="w-auto bg--500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Enviar</button>
                        </form>
                    </div>

                </div>
            </form> 

            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>  

<script>    
    $(document).ready(function() {
        var date = new Date();

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;       
        $("#fecha").attr("value", today);
        $("#fechaA").attr("value", today);
        $("#fecha").attr("max", today);
        $("#fechaA").attr("max", today);
    });

    $( "#fecha" ).datepicker({
        dateFormat : 'dd-mm-yy'
    });
    $( "#fechaA" ).datepicker({
        dateFormat : 'dd-mm-yy'
    });
</script>

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form  
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
                }//Se oculta el loader para que no tape toda la pantalla por siempre.
                else{
                    loader.style.display = "none";
                }
            })                      
      }, false)
    })})()
</script>