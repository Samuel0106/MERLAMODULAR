<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alta de Usuario') }}
        </h2>
    </x-slot>
    <style>
        /* CHECKBOX TOGGLE SWITCH */
        /* @apply rules for documentation, these do not work as inline style */
        .toggle-checkbox:checked {
          @apply: right-0 border-green-400;
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
            
            <form action="{{ route('datos.store') }}" method="POST" class="formEnviar" enctype="multipart/form-data">
            @csrf
                {{-- <x-jet-validation-errors class="mb-4 gap-5 md:gap-8 mt-5 mx-7" /> --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                        <input name="eid" class=" @error('eid') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('eid')}}" required/>
                        @error('eid')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">EMAIL:</label>
                        <input name="email" max="191" class=" @error('email') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="email" value="{{old('email')}}" required/>
                        @error('email')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                        <input name="nombre" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('nombre')}}" required/>
                        @error('nombre')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido Paterno:</label>
                        <input name="paterno" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('paterno')}}" required/>
                        @error('paterno')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div> 
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido Materno:</label>
                        <input name="materno" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('materno')}}" required/>
                    </div> 
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de Ingreso:</label>
                        <input name="ingreso" type="date"  min="1900-01-01" max="{{date('Y-m-d');}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('ingreso')}}" required/>
                        @error('ingreso')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div> 
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">DIVISION:</label>
                        <select disabled id="_divisiones" name="division" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required/>
                        @foreach ($divisiones as $division)

                        <option id="{{$division->division_clave}}" value="{{$division->division_clave}}">{{$division->division_nombre}}</option>
                            
                        @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">AREA:</label>
                        <select id="_areas" name="area" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required/>
                        @foreach ($areas as $area)

                        <option id="{{$area->area_clave}}" value="{{$area->area_clave}}">{{$area->area_nombre}}</option>
                            
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO DE TRABAJO:</label>
                        <select name="subarea" id="_subareas" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @foreach ($subareas as $subarea)

                            <option id="{{$subarea->subarea_clave}}" value="{{$subarea->subarea_clave}}">{{$subarea->subarea_nombre}}</option>
                            
                        @endforeach

                        </select>
                    </div>      
                </div>
                
                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                    <!-- botón cancelar -->
                    <a href="{{ route('salud.inicio') }}" style="text-decoration: none" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                    <!-- botón enviar -->
                    <button type="submit" class="rounded-lg bg-blue-500 hover:bg-green-700 font-medium text-black px-4 py-2">Enviar</button>
                </div>
            </form> 

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    (function () {
  'use strict'
  //debemos crear la clase formEliminar dentro del form del boton borrar
  //recordar que cada registro a eliminar esta contenido en un form 
  var loader = document.getElementById("preloader");    //Se guarda el loader en la variable. 
  var forms = document.querySelectorAll('.formEnviar')
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
                }
                else {
                    //Se oculta el loader para que no tape toda la pantalla por siempre.
                    loader.style.display = "none";
                }
            })                      
      }, false)
    })})()
</script>

<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
    document.getElementById('_areas').addEventListener('change',(e)=>{
        fetch(SITEURL + '/subarea',{
            method : 'POST',
            body: JSON.stringify({texto : e.target.value, "_token": "{{ csrf_token() }}"}),
            headers:{
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response =>{
            return response.json()
        }).then( data =>{
            var opciones ="";
            for (let i in data.lista) {
               opciones+= '<option value="'+data.lista[i].subarea_clave+'">'+data.lista[i].subarea_nombre+'</option>';
            }
            document.getElementById("_subareas").innerHTML = opciones;
        }).catch(error =>alert(error));
    })
</script>

