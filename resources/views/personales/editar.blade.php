<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Antecedentes Personales') }}
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

            <form action="{{ route('personales.update', $antecedentes_personales->id) }}" method="POST" enctype="multipart/form-data" class="formEnviar">
            @method('PATCH')
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7 py-4">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                        <input name="eid" value="{{$antecedentes_personales->eid}}" class=" @error('eid') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('eid')}}" required/>
                        @error('eid')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">DIVISION:</label>
                        <select id="_divisiones" name="division" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required/>
                        @foreach ($divisiones as $div)

                            @if ($div->division_clave == $divisionUser)
                                <option id="{{$div->division_clave}}" value="{{$div->division_clave}}">{{$div->division_nombre}}</option>
                            @endif     

                        @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">AREA:</label>
                        <select id="_areas" name="area" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required/>
                        @foreach ($areas as $area)

                            @if ($area->area_clave == $areaUser)
                                <option id="{{$area->area_clave}}" value="{{$area->area_clave}}">{{$area->area_nombre}}</option>
                            @endif
                        
                        @endforeach
                        </select>
                    </div>
                
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO DE TRABAJO:</label>
                        <select name="subarea" id="_subareas" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @foreach ($subareas as $subarea)

                            @if ($subarea->subarea_clave == $subareaUser)
                                <option id="{{$subarea->subarea_clave}}" value="{{$subarea->subarea_clave}}">{{$subarea->subarea_nombre}}</option>
                            @endif
                        
                        @endforeach

                        </select>
                    </div>      
                </div>
                
                <!--Antecedentes Personales -->
                <h2 class="font-semibold text-xl text-gray-800 leading-tight px-8 py-4"><br>Antecedentes Personales.</h2>

                <div class="grid grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">   
                        
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Total de Vacunas Covid:</label>
                        <input name="vacuna" type="number" value="{{$antecedentes_personales->vacuna}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de la ultima vacuna:</label>
                        <input name="fecha" type="date" min="1900-01-01" max="{{date('Y-m-d');}}" value="{{$antecedentes_personales->fecha}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Inmunizaciones:</label>
                        <input name="inmunizaciones" type="number" min="0" max="99" value="{{$antecedentes_personales->inmunizaciones}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">   
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cirugías:</label>
                        <textarea name="cirugia" rows="2" maxlength="191" style="resize:none" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent " type="text" required/>{{$antecedentes_personales->cirugia}}</textarea>
                    </div>
        
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Herencia:</label>
                        <textarea name="herencia" rows="2" maxlength="191" style="resize:none" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent " type="text" required/>{{$antecedentes_personales->herencia}}</textarea>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tabaquismo:</label>
                        <select name="tabaquismo" value="{{$antecedentes_personales->tabaquismo}}" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required/>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Alcoholismo:</label>
                        <select name="alcholismo" value="{{$antecedentes_personales->alcholismo}}" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required/>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Toxicomanias</label>
                        <select name="toxicomanias" value="{{$antecedentes_personales->toxicomanias}}" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required/>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Preferencias sexuales</label>
                        <input name="par_sexuales" value="{{$antecedentes_personales->par_sexuales}}" type="text" maxlength="191" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                </div>
                    
                
                <!--Antecedentes Ginecologicos -->
                <h2 class="font-semibold text-xl text-gray-800 leading-tight px-8 py-4"><br>Antecedentes Ginecológicos.</h2>

                <div class="grid grid-cols-5 gap-5 md:gap-8 mt-5 mx-7">

                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fum:</label>
                        <input name="fum" type="number" min="0" max="99" value="{{$antecedentes_personales->fum}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Menarca:</label>
                        <input name="menarca" type="text" maxlength="191" value="{{$antecedentes_personales->menarca}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                    
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Para:</label>
                        <input name="para" type="number" min="0" max="99" value="{{$antecedentes_personales->para}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Aborto</label>
                        <input name="aborto" type="number" min="0" max="99" value="{{$antecedentes_personales->aborto}}" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cesarias</label>
                        <input name="cesaria" type="number" min="0" max="99" value="{{$antecedentes_personales->cesaria}}" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Enfermedades Transmisión sexuales</label>
                        <textarea name="ets" style="resize:none" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent " type="text" required/>{{$antecedentes_personales->ets}}</textarea>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">anticonceptivos</label>
                        <textarea name="anticonceptivos" style="resize:none" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent " type="text" required/>{{$antecedentes_personales->anticonceptivos}}</textarea>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Pap</label>
                        <input name="pap" type="date" min="1900-01-01" max="2099-12-31" value="{{$antecedentes_personales->pap}}" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required/>
                    </div>
                </div>

                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5 mt-5'>
                    <!-- botón cancelar -->
                    <a href="{{ route('personales.indice', $antecedentes_personales->eid) }}" class="bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Cancelar</a>
                    <!-- botón enviar -->
                    <form action="{{ route('personales.index') }}" method="POST" class="formEnviar bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">

                        <button type="submit" style="background-color: rgb(21 128 61);" class="bg--500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-black px-4 py-2">Guardar</button>
                    </form>
                </div>

            </form> 

            </div>
        </div>
    </div>
</x-app-layout>

<script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>

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
                title: '¿Confirmar el guardado?',        
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#20c997',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire('Guardado!', 'El registro ha sido guardado exitosamente.','success');
                }
                //Se oculta el loader para que no tape toda la pantalla por siempre.
                else{
                    loader.style.display = "none";
                }
            })                      
      }, false)
    })})()
</script>