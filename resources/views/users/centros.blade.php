<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Centros de Trabajo') }}
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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="my-4 px-3 py-3 ml-4  leading-normal text-green-500 rounded-lg" role="alert">
                    <div class="text-left">
                        <a href="{{ url()->previous() }}"
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
                @csrf
                
                <div class="grid gap-5 md:gap-8 mt-5 mx-7">
                    <div class="grid grid-cols-2">
                        <div class="mx-10">
                            <label class="uppercase font-semibold">División:</label>
                            <select id="_divSelect" style="width: 80%" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($divisiones as $div)
                                    <option value={{$div->division_clave}}>{{ $div->division_nombre . "   - " . $div->division_clave }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mx-15">
                            <label class="uppercase font-semibold">Areas:  </label>
                            <select id="_areaSelect" style="width: 80%" class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($areas as $ars)
                                    <option value={{$ars->area_clave}}>{{ $ars->area_nombre . "   - " . $ars->area_clave }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table id="data-table" class="stripe hover translate-table" style="width:60%; padding-top: 1em;  padding-bottom: 1em; ">
                        <thead class="bg-gray-700 text-white">
                            <tr>
                                <th>Clave</th>
                                <th>Nombre</th>
                            </tr>  
                        </thead>    
                        <tbody>
                            @foreach ($subareas as $sub)
                                <tr>
                                    <td>{{$sub->subarea_clave}}</td>
                                    <td>{{$sub->subarea_nombre}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src={{asset('plugins/jquery/jquery-3.5.1.min.js')}}></script>
        <script src={{asset('plugins/dataTables/js/jquery.dataTables.min.js') }}></script>
        <script src={{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}></script>
        <script src={{ asset('js/customDataTables.js') }}></script>

    <script>
        $(function(){
            const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
            var SITEURL = "{{ url('/') }}";

            $('#_divSelect').on('change',function(){
                var div = document.getElementById("_divSelect").value;
                var areaUno;
                var table = $('#data-table').DataTable();

                fetch(SITEURL + '/areas',{
                    method : 'POST',
                    body: JSON.stringify({division : div, "_token": "{{ csrf_token() }}"}),
                    headers:{
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": csrfToken
                    },
                }).then(response =>{
                    return response.json()
                }).then( data =>{
                    var opciones;
                    areaUno = data.lareas[0];
                    for (let i in data.lareas) {
                        opciones += '<option value="'+data.lareas[i].area_clave+'">'+data.lareas[i].area_nombre+'</option>';
                    }
                    document.getElementById("_areaSelect").innerHTML = opciones;
                    
                    fetch(SITEURL + '/subareas',{
                        method : 'POST',
                        body: JSON.stringify({area : areaUno.area_clave, "_token": "{{ csrf_token() }}"}),
                        headers:{
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": csrfToken
                        },
                    }).then(response =>{
                        return response.json()
                    }).then( data =>{
                        
                        table.clear();

                        if(data.lsubarea.length != 0){
                            for (let i in data.lsubarea) {
                                table.row.add([
                                    data.lsubarea[i].subarea_clave,
                                    data.lsubarea[i].subarea_nombre
                                ]);
                            }
                        }
        
                        table.draw();
                    }).catch(error =>alert(error));

                }).catch(error =>alert(error));

            })
        })
    </script>
    <script>
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        var SITEURL = "{{ url('/') }}";
    
        $(function(){
            $('#_areaSelect').on('change',function(){
                var f_area = document.getElementById("_areaSelect").value;
                var table = $('#data-table').DataTable();

                fetch(SITEURL + '/subareas',{
                    method : 'POST',
                    body: JSON.stringify({area : f_area, "_token": "{{ csrf_token() }}"}),
                    headers:{
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": csrfToken
                    },
                }).then(response =>{
                    return response.json()
                }).then( data =>{
                    
                    table.clear();

                    if(data.lsubarea.length != 0){
                        for (let i in data.lsubarea) {
                            table.row.add([
                                data.lsubarea[i].subarea_clave,
                                data.lsubarea[i].subarea_nombre
                            ]);
                        }
                    }
    
                    table.draw();
                }).catch(error =>alert(error));
            });
        });
    </script>
@endsection
</x-app-layout>