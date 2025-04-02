<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedido Especial') }}
        </h2>
    </x-slot>

    @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="my-4 px-4 py-3 ml-2 leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ route('inventarios.inicio') }}"
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
                <form action="{{ route('inventarios.especial_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 col-span-2 mx-10">
                        <h2 class="font-semibold text-xl text-gray-500 justify-self-center mt-10">Información del pedido</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-2 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Solicitante</label>
                            <input disabled class="py-2 px-3 rounded-lg border-2 bg-gray-400 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 " type="text" value="{{$datos->nombre . " " . $datos->paterno . " " . $datos->materno }}" />
                            <input hidden name="solicitante" value="{{$datos->eid}}" />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Encargado</label>
                            <select name="responsable" required class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($almacenes as $almacen)
                                @if($almacen->jefe)
                                <option value="{{$almacen->jefe_eid}}">{{$almacen->jefe->nombre . " " . $almacen->jefe->paterno . " - " . $almacen->almacen_nombre}}</option>
                                @else
                                <option value="{{$almacen->jefe_eid}}">{{$almacen->almacen_nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('responsable')
                            <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 col-span-2 mx-10">
                        <h2 class="font-semibold text-xl text-gray-500 justify-self-center mt-10">Información del producto</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-2 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nombre del producto</label>
                            <input name="nombre_producto" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required />
                            @error('nombre_producto')
                            <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Cantidad</label>
                            <input name="cantidad" type="number" min='1' class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required />
                            @error('cantidad')
                            <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-5 md:gap-8 mt-3 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Descripcion</label>
                            <input name="descripcion" class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required />
                            @error('descripcion')
                            <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:gap-8 mt-4 mx-7">
                        <div class='flex items-center justify-center w-full'>
                            <label class='flex flex-col group'>
                                <div class='flex flex-col items-center justify-center pt-7'>
                                    <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Fotografia de Referencia</label>
                                    <img id="imagenPE" style="max-height: 300px;max-width: 400px;min-height: 260px;min-width: 350px;" class="flex flex-col border-4 border-dashed w-full h-full border-green-300">
                                    <input name="foto" id="foto" type='file' />
                                </div>
                                @error('foto')
                                <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-5 md:gap-8 mt-3 mx-7">
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Justificacion</label>
                            <input name="justificacion" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" required />
                            @error('justificacion')
                            <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 font-semibold">Nivel de Importancia</label>
                            <select name="import" id="importSelect" required class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="1">Bajo</option>
                                <option value="2">Medio</option>
                                <option value="3">Alto</option>
                                <option value="4">Urgente</option>
                            </select>
                            @error('import')
                            <p class=" text-red-500 text-sm text-right "> {{$message}} </p>
                            @enderror
                        </div>
                    </div>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <!-- botón cancelar -->
                        <a href="{{ url()->previous()  }}" class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <!-- botón enviar -->
                        <button type="submit" class="w-auto bg-blue-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">Enviar</button>
                    </div>
                </form>
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
    $(document).ready(function(e) {
        $('#foto').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenPE').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>