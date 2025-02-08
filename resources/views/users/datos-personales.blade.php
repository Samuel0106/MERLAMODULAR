<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Datos personales') }}
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información usuario -->
            <div class="mt-4 bg-white  overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1">
                    <div class="p-3 border-t border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            eid:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$datos->eid}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Nombre:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$datos->nombre}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Apellido paterno:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$datos->paterno}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Apellido materno:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$datos->materno}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Antiguedad:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$datos->ingreso}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Contrato:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$contrato}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            División:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$division->division_nombre}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Area:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$area}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Subarea:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$subarea}}</p> 
                        </div>
                    </div>
                    <div class="p-3 border-gray-200">
                        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
                            Correo:<p class="text-lg font-medium text-gray-900p.ex1 ml-2">{{$correo->email}}</p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>