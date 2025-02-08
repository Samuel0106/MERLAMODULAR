<div class="py-6">
    <div class="mt-2 px-4 py-3 ml-11 mb-6 leading-normal text-green-500 rounded-lg" role="alert">
        <div class="text-left">
            <a href="{{ route('inventarios.inicio') }}" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                </svg>
                Regresar
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-2">
            <select wire:model='selectedArea' name="area" id="areaSelect" class="py-2 px-3 w-96 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                @foreach ($areas as $area)
                <option id="{{ $area->id }}" value="{{ $area->area_clave }}">{{ $area->area_nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <table id="data-table" class="table table-striped table-bordered shadow-lg table-fixed w-full  translate-table">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="border px-4 py-2">ALMACEN</th>
                        <th class="border px-4 py-2">ESTADO</th>
                        <th class="border px-4 py-2">JEFE eid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($almacenes as $almacen)
                    <tr>
                        <td>{{ $almacen->almacen_nombre }}</td>
                        <td class="border px-4 py-2">
                            <label class="switch">
                                @if ($almacen->habilitado)
                                <input value='check{{$almacen->id}}' wire:change="update({{ $almacen->id }})" type="checkbox" checked>
                                @else
                                <input value='check{{$almacen->id}}' wire:change="update({{ $almacen->id }})" type="checkbox" unchecked>
                                @endif
                                <span id="slide{{$almacen->id}}" class="slider round after:bg-green-300 before:bg-gray-400"></span>
                            </label>
                        </td>
                        <td>
                            @php
                            $usuario = $this->usuarioExiste($almacen->jefe_eid);
                            $are = $this->returnArea($almacen->area_id);
                            @endphp
                            {{ info($are); }}
                            @if ($usuario)
                            <button onclick="actualizarDiv({{ json_encode($almacen) }}, {{ json_encode($usuario) }}, {{ json_encode($are) }})" class="text-blue-400 hover:text-blue-700">
                                {{
                                            $almacen->jefe_eid . 
                                            " - " . 
                                            $usuario->nombre . 
                                            " " . 
                                            $usuario->paterno
                                        }}
                            </button>
                            @else
                            <button onclick="actualizarDiv({{ json_encode($almacen) }}, 1, {{ json_encode($are) }})" class="text-blue-400 hover:text-blue-700">
                                {{ $almacen->jefe_eid . " - No Encontrado"}}
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="divEscondido" style="display: none" class="border shadow-xl sm:rounded-lg pb-3 pt-3">
            <div class="flex pt-4 pb-4 border bg-white">
                <div class="col-4">
                    <div class="font-bold pb-1">Buscar Usuario Para Nuevo Jefe de Almacen</div>
                    <div class=""><input id="buscaeid" type="text" value=""></div>
                </div>
                <div class="col-4 pt-4"><button onclick="buscarUser(document.getElementById('buscaeid').value , document.getElementById('area').innerText)" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">Buscar</div>
            </div>

            <div class="flex pt-4 border bg-gray-200">
                <div class="col-4 font-bold">Almacen Clave</div>
                <div id="clAlmacen" class="col-4">Almacen Clave</div>
            </div>

            <div class="flex pt-4 border bg-white">
                <div class="col-4 font-bold">Almacen Nombre</div>
                <div id="noAlmacen" class="col-4">Almacen Nombre</div>
            </div>

            <div class="flex pt-4 border bg-gray-200">
                <div class="col-4 font-bold">Area</div>
                <div class="flex">
                    <div id="area" class="col-4">area</div>
                    <div id="nombreArea" class="pl-2 flex text-nowrap">Area</div>
                </div>
            </div>

            <div class="flex pt-4 border bg-white">
                <div class="col-4 font-bold">eid</div>
                <div id="jeeid" class="col-4">eid</div>
            </div>

            <div class="flex pt-4 border bg-gray-200">
                <div class="col-4 font-bold">Nombre</div>
                <div id="noJefe" class="col-4">eid</div>
            </div>

            <div id="divUser" style="display: none" class=" flex pt-4 border pb-4">
                <div class="col-4 font-bold">Usuario encontrado</div>
                <div class="flex col-8 pt-2">
                    <div id="eid">eid</div>
                    <div id="usuario_encontrado" class="pl-2">Nombre</div>
                </div>
            </div>

            <div class="flex pt-4 border pb-4 bg-white">
                <div class="col-4"><button wire:click="actualizarJefeeid(document.getElementById('eid').innerText, (document.getElementById('clAlmacen').innerText))" id="botonGuardar" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">Guardar Cambios</button></div>
                <div onclick="ocultaDiv() " class="col-4"><button class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2' type="button">Cancelar</button></div>
            </div>
        </div>
    </div>

    <script>
        function mostrarDiv() {
            // Obtener elementos del DOM
            var div = document.getElementById("divEscondido"); // Obtener el elemento con el ID "divEscondido"
            var boton = document.getElementById("botonGuardar"); // Obtener el elemento con el ID "botonGuardar"
            var divUs = document.getElementById("divUser"); // Obtener el elemento con el ID "divUser"

            // Ocultar otro elemento del DOM
            divUs.style.display = "none"; // Ocultar el elemento con el ID "divUser"

            // Mostrar elemento del DOM
            div.style.display = "block"; // Mostrar el elemento con el ID "divEscondido"

            // Deshabilitar un botón
            boton.disabled = true; // Deshabilitar el botón con el ID "botonGuardar"

            // Establecer el valor de un campo de entrada
            document.getElementById("buscaeid").value = ""; // Establecer el valor del campo de entrada con el ID "buscaeid" como una cadena vacía

            // Desplazarse a un elemento del DOM
            div.scrollIntoView({
                behavior: "smooth"
            }); // Desplazarse al elemento con el ID "divEscondido" suavemente (usando el comportamiento "smooth")
        }

        function ocultaDiv() {
            // Obtener elementos del DOM
            var div = document.getElementById("divEscondido"); // Obtener el elemento con el ID "divEscondido"
            var boton = document.getElementById("botonGuardar"); // Obtener el elemento con el ID "botonGuardar"
            var divd = document.getElementById("divUser"); // Obtener el elemento con el ID "divUser"

            // Establecer el valor de un campo de entrada
            document.getElementById("buscaeid").value = ""; // Establecer el valor del campo de entrada con el ID "buscaeid" como una cadena vacía

            // Ocultar elementos del DOM
            div.style.display = "none"; // Ocultar el elemento con el ID "divEscondido"
            divd.style.display = "none"; // Ocultar el elemento con el ID "divUser"

            // Deshabilitar un botón
            boton.disabled = true; // Deshabilitar el botón con el ID "botonGuardar"
        }

        function buscarUser(usuario, area) {
            // Declarar url del sistema
            var SITEURL = "{{ url('/') }}";
            // Obtener elementos del DOM
            var div = document.getElementById("usuario_encontrado"); // Obtener el elemento con el ID "userusuario_encontrado"
            var divd = document.getElementById("eid"); // Obtener el elemento con el ID "eid"
            var boton = document.getElementById("botonGuardar"); // Obtener el elemento con el ID "botonGuardar"

            // Variables adicionales
            var flag = 0; // Una variable de indicador de éxito

            // Deshabilitar un botón
            boton.disabled = true; // Deshabilitar el botón con el ID "botonGuardar"

            // Realizar una solicitud HTTP GET usando fetch API
            fetch(SITEURL + '/buscar-user/' + usuario)
                .then(response => response.json()) // Analizar la respuesta HTTP como JSON
                .then(usuarioEncontrado => { // Manejar la respuesta JSON
                    if (usuarioEncontrado != null) { // Si se encontró un usuario
                        if (area === `${usuarioEncontrado.area}`) // Si el usuario pertenece al área especificada
                        {
                            if (usuarioEncontrado.eid != document.getElementById("jeeid").innerHTML.trim()) // Si el usuario no es el mismo que el jefe actual
                            {
                                // Actualizar elementos del DOM
                                divd.innerHTML = `${usuarioEncontrado.eid}`;
                                div.innerHTML = `- ${usuarioEncontrado.nombre} ${usuarioEncontrado.paterno} ${usuarioEncontrado.materno}`;
                                flag = 1; // Indicar éxito
                                options(flag); // Actualizar otros elementos del DOM según el éxito
                            } else // Si el usuario es el mismo que el jefe actual
                            {
                                // Actualizar elementos del DOM
                                divd.innerHTML = "Este Usuario ";
                                div.innerHTML = "ya es jefe de este Almacen";
                                options(flag); // Actualizar otros elementos del DOM según el éxito
                            }
                        } else // Si el usuario no pertenece al área especificada
                        {
                            // Actualizar elementos del DOM
                            divd.innerHTML = "El Usuario ";
                            div.innerHTML = "no Pertenece al Area";
                            options(flag); // Actualizar otros elementos del DOM según el éxito
                        }
                    }
                })
                .catch(error => {
                    console.log(error); // Manejar errores
                    div.innerHTML = "no encontrado"; // Actualizar elementos del DOM
                    divd.innerHTML = "Usuario";
                    options(flag); // Actualizar otros elementos del DOM según el éxito
                });
        }

        function options(flag) {
            // Obtener los elementos necesarios del DOM
            var div = document.getElementById("divUser");
            var boton = document.getElementById("botonGuardar");

            // Mostrar el div de usuario
            div.style.display = "block";

            // Si el usuario se encontró, se agrega una clase de color verde y se habilita el botón de guardar
            if (flag === 1) {
                div.classList.add("bg-green-100");
                div.classList.remove("bg-red-100");
                boton.disabled = false;
            }
            // Si el usuario no se encontró, se agrega una clase de color rojo y se deshabilita el botón de guardar
            else {
                div.classList.add("bg-red-100");
                div.classList.remove("bg-green-100");
                boton.disabled = true;

                // Limpiar el campo de búsqueda de eid
                document.getElementById("buscaeid").value = "";
            }

            // Desplazarse hacia el div de usuario para que sea visible en la pantalla
            div.scrollIntoView({
                behavior: "smooth"
            });
        }

        function actualizarDiv(almacen, usuario, are) {
            // muestra el campo donde estará la información
            mostrarDiv();

            // obtiene los elementos HTML que se van a actualizar
            var clAlmacen = document.getElementById("clAlmacen");
            var noAlmacen = document.getElementById("noAlmacen");
            var jeeid = document.getElementById("jeeid");
            var nombre = document.getElementById("noJefe");
            var area = document.getElementById("area");
            var noArea = document.getElementById("nombreArea");

            // actualiza los valores de los elementos con la información del almacen y su jefe
            clAlmacen.innerHTML = almacen.almacen_clave;
            noAlmacen.innerHTML = almacen.almacen_nombre;
            jeeid.innerHTML = almacen.jefe_eid;
            area.innerHTML = almacen.area_id;
            noArea.innerHTML = are.area_nombre;

            // almacena el id del almacen
            var id = almacen.id;

            // si se encontró al usuario jefe, actualiza su nombre en el elemento HTML correspondiente
            if (usuario !== 1) {
                nombre.innerHTML = usuario.nombre + " " + usuario.paterno + " " + usuario.materno;
            }
            // si no se encontró al usuario jefe, muestra un mensaje en el elemento HTML correspondiente
            else {
                nombre.innerHTML = "No Encontrado";
            }
        }
    </script>

</div>