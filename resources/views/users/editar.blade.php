<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar usuario') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                            <input disabled name="eid" value="{{ $user->eid }}"
                                class=" @error('eid') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" value="{{ old('eid') }}" required />
                            @error('eid')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">email:</label>
                            <input disabled name="email" value="{{ $user->email }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nombre:</label>
                            <input disabled name="nombre" value="{{ $datos->nombre }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido
                                Paterno:</label>
                            <input disabled name="paterno" value="{{ $datos->paterno }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Apellido
                                Materno:</label>
                            <input disabled name="materno" value="{{ $datos->materno }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Fecha de
                                Antigüedad:</label>
                            <input disabled name="ingreso" type="date" value="{{ $datos->ingreso }}"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Contrato:</label>
                            <select name="contrato" id="contrato"
                                class="@error('contrato') is-invalid @enderror py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option id="SINDICALIZADO TEMPORAL" value="7">
                                    SINDICALIZADO TEMPORAL
                                </option>
                                <option id="SINDICALIZADO BASE" value="6">
                                    SINDICALIZADO BASE
                                </option>
                                <option id="CONFIANZA TEMPORAL" value="2">
                                    CONFIANZA TEMPORAL
                                </option>
                                <option id="CONFIANZA BASE" value="1">
                                    CONFIANZA BASE
                                </option>
                                <option id="JUBILADO" value="3">
                                    JUBILADO
                                </option>
                                <option id="BAJA" value="4">
                                    BAJA
                                </option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">PUESTO:</label>
                            <select id="_puesto" name="puesto"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required>
                                @foreach (App\Models\Puesto::all() as $puesto)
                                    <option id="{{ $puesto->id }}" value="{{ $puesto->nombre_puesto }}"
                                        {{ $datos->puesto == $puesto->nombre_puesto ? 'selected' : '' }}>
                                        {{ $puesto->nombre_puesto }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">DIVISIÓN:</label>
                            <select id="_divisiones" name="division"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required>
                                @foreach ($divisiones as $division)
                                    <option id="{{ $division->division_clave }}"
                                        value="{{ $division->division_clave }}"
                                        {{ $division_id == $division->division_clave ? 'selected' : '' }}>
                                        {{ $division->division_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA:</label>
                            <select id="_areas" name="area"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                required />
                            @foreach ($areas as $area)
                                <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}"
                                    {{ $area_id == $area->area_clave ? 'selected' : '' }}>
                                    {{ $area->area_nombre }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Subárea
                                correspondiente:</label>
                            <select name="subarea" id="_subareas"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @foreach ($subareas as $subarea)
                                    <option id="{{ $subarea->subarea_clave }}" value="{{ $subarea->subarea_clave }}"
                                        {{ $datos->subarea == $subarea->subarea_clave ? 'selected' : '' }}>
                                        {{ $subarea->subarea_nombre }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <br>
                    <center>
                        <table id="data-table" class="grid grid-cols-1 place-items-center"
                            style= "width:50%; padding-top: 1em;  padding-bottom    : 1em; border-spacing: 5px;
                            border-collapse: separate;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Roles</th>
                                </tr>
                            </thead>

                            @foreach ($roles as $role)
                                <tr data-id="{{ $role->name }}">

                                    <td><input type="checkbox" name="roles[]" id="roles"
                                            value="{{ $role->name }}"
                                            @if ($user->hasRole($role)) checked=checked @endif></td>
                                    <td style="
                                direction:lft;
                                text-align:justify;"">
                                        {{ $role->name }} </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </center>
                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('users.index') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit"
                            class='w-auto bg-blue-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
<script>
    let con = document.getElementById('contrato');
    Array.from(con.options).forEach(function(element, index) {
        console.log(element);
        if (element.value == {{ $datos['contrato'] }}) {
            con.selectedIndex = index;
        }
    });

    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    var SITEURL = "{{ url('/') }}";
    document.getElementById('_areas').addEventListener('change', (e) => {
        fetch(SITEURL + '/subarea', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].subarea_clave + '">' + data.lista[i]
                    .subarea_nombre + '</option>';
            }
            document.getElementById("_subareas").innerHTML = opciones;
        }).catch(error => alert(error));
    })

    document.getElementById('_divisiones').addEventListener('change', (e) => {
        fetch(SITEURL + '/areas', {
            method: 'POST',
            body: JSON.stringify({
                texto: e.target.value,
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).then(data => {
            var opciones = "";
            var opciones1 = "";
            for (let i in data.lista) {
                opciones += '<option value="' + data.lista[i].area_clave + '">' + data.lista[i]
                    .area_nombre + '</option>';
            }
            for (let i in data.listaSub) {
                opciones1 += '<option value="' + data.listaSub[i].subarea_clave + '">' + data.listaSub[
                    i].subarea_nombre + '</option>';
            }
            document.getElementById("_areas").innerHTML = opciones;
            document.getElementById("_subareas").innerHTML = opciones1;
        }).catch(error => alert(error));
    })

    function changeRole(id) {
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        var rol = document.getElementById(id + 'select').value;
        fetch('users/' + id, {
            method: 'PUT',
            body: JSON.stringify({
                rol: rol,
                origen: 'fetch',
                "_token": "{{ csrf_token() }}"
            }),
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            },
        }).then(response => {
            return response.json()
        }).catch(error => alert(error));
    }
</script>
