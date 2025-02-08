<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('USUARIOS DADOS DE BAJA') }}
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
<!--            <button type="submit" class="rounded text-white font-bold py-2 px-4">Borrar</button> -->

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6" style="width:100%;">

                <table id="data-table" class="stripe hover translate-table"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead>
                        <tr>

                            <th>eid</th>
                            {{-- <th>Correo</th> --}}
                            <th>Contrato</th>
                            <th>Puesto</th>
                            <th>Área</th>
                            <th>Centro de trabajo</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        @if(App\Models\DatosUser::where('eid', $user->eid)->get()->first() != null) <!--Revisa si el usuario tiene datos-->
                            <tr data-id="{{ $user->id }}">
                                <td class="px-6 py-4 text-center mostrar-usuario">
                                    <div>
                                        {{ $user->eid }}
                                    </div>
                                </td>
                                {{-- <td class="px-6 py-4 text-center mostrar-usuario">
                                    <div>
                                        {{ $correos[$index]->email }}
                                    </div>
                                </td> --}}
                                <td class="px-6 py-4 text-center mostrar-usuario">
                                    <div>
                                        @if($user->contrato == '3')
                                            {{ 'Jubilado' }}
                                        @endif
                                        @if($user->contrato == '4')
                                            {{ 'Dado de baja' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center mostrar-usuario">
                                    <div>
                                        {{ $user->puesto }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center mostrar-usuario">
                                    <div>
                                        <?php
                                            foreach($areas as $area){
                                                if($area->area_clave == $user->area){
                                                    echo($area->area_nombre);
                                                    break;
                                                }
                                            }   
                                        ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center mostrar-usuario">
                                    <div>
                                        <?php
                                            foreach($subareas as $subarea){
                                                if($subarea->subarea_clave == $user->subarea){
                                                    echo($subarea->subarea_nombre);
                                                    break;
                                                }
                                            }   
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            @endif
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