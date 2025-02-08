<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expedientes Medicos de Usuarios') }}
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
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">
                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>
                            <th>eid</th>
                            <th>NOMBRES</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>AREA</th>
                            <th>SUBAREA</th>
                            <th>ACCIONES</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($datosuser as $dato)
                        <tr data-id="{{ $dato->id }}">
                            <td>{{$dato->eid}}</td>
                            <td>{{$dato->nombre}}</td>
                            <td>{{$dato->paterno}}</td>
                            <td>{{$dato->materno}}</td>
			    @if($dato->getArea!=null)
                            <td>{{$dato->getArea->area_nombre}}</td>
			    @else
			    <td>-</td>
			    @endif
                            @if($dato->getSubarea!=null)
                            <td>{{$dato->getSubarea->subarea_nombre}}</td>
			    @else
			    <td>-</td>
                            @endif
                            <td>
                                <div class="flex justify-center rounded-lg text-lg" role="group">
                                    <!-- Crear expediente -->
                                    <a href="{{ route('saluds.indice', $dato->eid) }}" style="text-decoration: none" class="rounded-lg bg-blue-500 hover:bg-blue-600 text-black hover:text-white font-semibold py-2 px-4 ml-2" >Nota Medica</a>
                                    <!-- Crear antecedentes -->
                                    <a href="{{ route('personales.indice', $dato->eid) }}" style="text-decoration: none" class="rounded-lg bg-blue-500 hover:bg-blue-600 text-black hover:text-white font-bold py-2 px-4 ml-2" >Antecedentes</a>
                                    <!-- Editar usuario -->
                                    {{--@if (@Auth::user()->hasRole('admin'))
                                        <a href="{{ route('datos.edit', $dato->id) }}" style="text-decoration: none" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 text-black hover:text-white font-semibold py-2 px-4 ml-2">Editar</a>
                                    @endif--}}                                    
{{--                                      <!-- botón bajar -->
                                    <form action="{{ route('datos.bajar') }}" method="POST" class="rounded-lg bg-red-600 hover:bg-red-600 text-black font-bold py-2 px-4">
                                        @csrf
                                        <input type="text" class="hidden" name="id" value="{{$dato->id}}">
                                        <button type="submit">BAJA</button>
                                    </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
