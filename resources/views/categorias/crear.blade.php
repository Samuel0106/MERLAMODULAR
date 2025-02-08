<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Categoría') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <x-jet-validation-errors class="mb-4 gap-5 md:gap-8 mt-5 mx-7" /> --}}
                    <div class="my-4 px-4 py-3 ml-3 leading-normal text-green-500 rounded-lg" role="alert">
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
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-5 md:gap-8 mt-5 mx-7">

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre de la Categoría:</label>
                            <input name="nombre_cat" class=" @error('nombre_cat') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="text" value="{{old('eid')}}" required />
                            @error('nombre_cat')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror

                        </div>

                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('categorias.index') }}" class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>