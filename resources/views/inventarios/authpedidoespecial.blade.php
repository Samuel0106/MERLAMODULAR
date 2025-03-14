<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autorizar pedido especial N°' . $pedido->id) }}
        </h2>
    </x-slot>

    @section('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
    @endsection
    
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


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" style="width:100%;">
                <div class="mt-8 mb-6 px-4 py-3 ml-5 leading-normal text-green-500 rounded-lg" role="alert">
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

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-1">
                        <?php
                            $users = App\Models\Datosuser::whereeid($pedido->solicitante)->first();
                            if($users != null){$nombres = $users->paterno . " " . $users->materno . ", " . $users->nombre;}
                            else{$nombres = "Desconocido - ". $pedido->solicitante;}
                        ?>
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Solicitante: </label>
                        <input style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                        class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 
                        focus:ring-blue-700 focus:border-transparent" disabled value="{{$nombres}}" />
                    </div>
                    <div class="grid grid-cols-1">
                        <?php
                        $userr = App\Models\Datosuser::whereeid($pedido->responsable)->first();
                        if($userr != null){$nombrer = $userr->paterno . " " . $userr->materno . ", " . $userr->nombre;}
                        else{$nombrer = "Desconocido - ". $pedido->responsable;}
                        ?>
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Responsable: </label>
                        <input style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                        class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 
                        focus:ring-blue-700 focus:border-transparent" type="text" disabled value="{{$nombrer}}" />
                    </div>
                    <div class="flex items-center justify-center">
                    @if ( $pedido->foto != null)
                        <img src={{asset('/pedidoespecial/' . $pedido->foto) }} style="max-height: 300px; min-height: 200px; " class="h-200 py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent hover:bg-green-7000 hover:border-blue-600">                              
                    @else
                        <img src="{{ asset('imagen_productos/iconProduct.png') }}"width="200ppx" id="imagenSeleccionada" alt="Foto actual del producto" style="max-height: 300px; min-height: 200px; " class="h-200 py-2 px-3 rounded-lg border-2 border-green-800  focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent hover:bg-green-7000 hover:border-green-800">
                    @endif
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="mt-1 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre del producto: </label>
                        <input style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                        class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 
                        focus:ring-blue-700 focus:border-transparent" value="{{$pedido->nombre_producto}}" disabled />

                        <label class="mt-1 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cantidad: </label>
                        <input style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                        class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 
                        focus:ring-blue-700 focus:border-transparent" value="{{$pedido->cantidad}}" disabled />
                        
                        <label class="mt-1 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Descripción: </label>
                        <input style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                        class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 
                        focus:ring-blue-700 focus:border-transparent" value="{{$pedido->descripcion}}" disabled />

                        <label class="mt-1 uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Justificación: </label>
                        <input style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                        class=" py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 
                        focus:ring-blue-700 focus:border-transparent" value="{{$pedido->justificacion}}" disabled />
                    </div>
                </div>
                <input hidden name="pedido" value='{{$pedido}}' />
                <div class="float-center rounded-lg text-lg inline-flex gap-4 my-4 mx-10">
                    @if($pedido->estado == "Pendiente")
                        <div class="grid place-content-center mt-1">
                            <a type="button"
                                href="{{ route('inventarios.createpedidoespecial', ['auth'=>'1','pedido'=>$pedido]) }}"
                                class="invSubmit bg-blue-500 px-12 py-2 rounded text-white font-semibold hover:bg-blue-600 transition duration-200 each-in-out">
                                Autorizar Pedido</a>
                        </div>
                        <div class="grid place-content-center mt-1">
                            <a type="button"
                                href="{{ route('inventarios.createpedidoespecial', ['auth'=>'0','pedido'=>$pedido]) }}"
                                class="invSubmit bg-red-600 px-12 py-2 rounded text-white font-semibold hover:bg-red-700 transition duration-200 each-in-out">
                                Rechazar Pedido</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>