<div>
    <div id="preloader-livewire" wire:loading>
    </div>
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

                <form action="{{ route('inventarios.store') }}" method="post" id="formGuardar">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">eid:</label>
                            <input disabled name="eid" value='{{ $datos->eid }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            <input name="eid" value='{{ $datos->eid }}' class="hidden" type="text" required />
                        </div>

                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">NOMBRE:</label>
                            <input disabled name="nombre"
                                value="{{ $datos->paterno . ' ' . $datos->materno . ', ' . $datos->nombre }}"
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-grey-700 focus:border-transparent"
                                type="text" required />
                            <input name="nombre"
                                value="{{ $datos->paterno . ' ' . $datos->materno . ', ' . $datos->nombre }}"
                                class="hidden" type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">EMAIL:</label>
                            <input disabled name="email" value='{{ $user->email }}'
                                style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="text" required />
                            <input name="email" value='{{ $user->email }}' class="hidden" type="text" required />
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold"
                                for="dateStart">FECHA REQUERIDA DE ENTREGA:</label>
                            <input type="date" id="dateStart" name="fecha_estimada" min="" max=""
                                data-disable-weekends="true"
                                class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        @if (\Gloudemans\Shoppingcart\Facades\Cart::content()->count() == 0)
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                    ÁREA DEL ALMACEN AL QUE SE LE SOLICITA PRODUCTOS:
                                </label>
                                <select @if (Auth::user()->hasRole('usuario') || !(auth()->user()->datos->getArea == 'DN0')) disabled @endif name="area"
                                    value="$area->area_nombre" wire:model="areaSeleccionada"
                                    wire:change="actualizarSubareas"
                                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                @foreach ($areas as $area)
                                    <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}">
                                        {{ $area->area_nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                    ALMACEN AL QUE SE LE SOLICITA PRODUCTOS:</label>

                                <select id="_almacen" name="almacen" value='$almacen->almacen_nombre'
                                    wire:model="almaceneseleccionado" wire:change="actualizarProductos"
                                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 
                                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />

                                @foreach ($almacenes as $almacen)
                                    <option value="{{ $almacen->almacen_clave }}">
                                        {{ $almacen->almacen_nombre }}
                                        {{-- -
                                             {{DB::table('datosusers')->where('eid',$almacen->jefe_eid)->value('nombre') . " " . DB::table('datosusers')->where('eid',$almacen->jefe_eid)->value('paterno') . " " . DB::table('datosusers')->where('eid',$almacen->jefe_eid)->value('materno')}} --}}
                                    </option>
                                @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1">
                                <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA
                                    DEL CENTRO DE TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <select @if (Auth::user()->hasRole('usuario') || !(auth()->user()->datos->getArea == 'DN0')) disabled @endif name="area1"
                                    value="$area1->area_nombre" wire:model="areaSeleccionada1"
                                    wire:change="actualizarSubareas1"
                                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                @foreach ($areas1 as $area)
                                    <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}">
                                        {{ $area->area_nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-1">
                                <label
                                    class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO
                                    DE
                                    TRABAJO DONDE SE VA A ENTREGAR:</label>
                                <select @if (Auth::user()->hasRole('usuario')) disabled @endif name="subarea"
                                    wire:model="subareaSeleccionada1" wire:change="cambioSubDestino"
                                    class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 
                                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                @foreach ($subareas1 as $subarea)
                                    <option id="{{ $subarea->subarea_clave }}" value="{{ $subarea->subarea_clave }}">
                                        {{ $subarea->subarea_nombre }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                    </div>
                @else
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA DEL
                            ALMACEN AL QUE SE LE SOLICITA:</label>
                        <select name="area"
                            style="border-color: rgb(21 128 61);background-color: rgb(240, 240, 240);"
                            class="py-2 px-3 rounded-lg border-2  mt-1  focus:ring-green-500 " type="text"
                            required>
                            <option value="{{ $areaAux }}">
                                {{ App\Models\Area::find($areaAux)->area_nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                            ALMACEN AL QUE SE LE SOLICITA:</label>
                        <input name="almacen" value='{{ $subareaAux }}' class="hidden" type="text" />
                        <input disabled value='{{ App\Models\Almacen::find($subareaAux)->almacen_nombre }}'
                            style="border-color: rgb(21 128 61)"
                            class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                            type="text" />
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">ÁREA
                            DEL
                            CENTRO DE TRABAJO DONDE SE VA A ENTREGAR:</label>
                        <select name="area1" value="$area1->area_nombre" wire:model="areaSeleccionada1"
                            wire:change="actualizarSubareas1" style="background-color: rgb(240, 240, 240);"
                            class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @foreach ($areas1 as $area)
                                <option id="{{ $area->area_clave }}" value="{{ $area->area_clave }}">
                                    {{ $area->area_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">CENTRO
                            DE
                            TRABAJO DONDE SE VA A ENTREGAR:</label>
                        <select name="subarea" value="$subarea1->subarea_nombre" wire:model="subareaSeleccionada1"
                            wire:change="cambioSubDestino" style="background-color: rgb(240, 240, 240);"
                            class="py-2 px-3 rounded-lg border-2 border-blue-600 mt-1 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @foreach ($subareas1 as $subarea)
                                <option value="{{ $subarea->subarea_clave }}">{{ $subarea->subarea_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            @endif
            </form>
            <div class="my-4 px-4 py-3 mr-1 leading-normal text-blue-700 inline-flex-reverse" role="alert">
                <div class="inline-flex-reverse">
                    @if ($errors->any())
                        <div class="px-2 flex-row">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="px-2 inline-flex flex-row text-black" id="mssg-status">
                            {{ session()->get('message') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-green-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @elseif(session()->has('error'))
                        <div class="px-2 inline-flex flex-row py-1 text-black" id="mssg-status">
                            {{ session()->get('error') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex text-red-500"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                    <!-- Contador de productos en el carrito -->
                    <div class="px-2 flex flex-row-reverse">

                        <!-- Modal toggle -->
                        <div class="ml-4 bg-blue-600 rounded-lg">
                            <button
                                class="block openModal text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button" data-modal-toggle="defaultModal">
                                Ver carrito
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="fixed z-10 inset-0 invisible overflow-y-auto" aria-labelledby="modal-title"
                            role="dialog" aria-modal="true" id="interestModal">
                            <div
                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                    aria-hidden="true">?</span>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg @click="toggleModal" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 text-blue-600 place-self-center" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                    id="modal-title">
                                                    Productos en el carrito
                                                </h3>
                                                <div class="mt-2">
                                                    <ol class="text-sm text-gray-500">
                                                        @foreach ($carro as $item)
                                                            <li>
                                                                Producto: @if (is_array($item))
                                                                    {{ $item['name'] }}
                                                                @else
                                                                    {{ $item->name }}
                                                                @endif
                                                                Cantidad: @if (is_array($item))
                                                                    {{ $item['qty'] }}
                                                                @else
                                                                    {{ $item->qty }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button onclick="guardarInventario()" type="button"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Guardar solicitud
                                        </button>
                                        <button type="button"
                                            class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        ({{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() }})
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        Carrito

                        {{-- @livewire('cart-counter') --}}
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                            style="padding-left: 2em; padding-right: 2em;">
                            <div class="flex items-center justify-between pt-2 pb-1">
                                <input type="text"
                                    class="w-64 px-4 py-2 ml-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Buscar Producto..." wire:model="inputBusqueda">

                                @if ($flagDatos == false || $paginaSeleccionada != 0)
                                    <div class="flex items-center">pagina {{ $paginaSeleccionada }} de
                                        {{ $cantidadBotones }}</div>
                                @endif

                                <div class="flex items-center">
                                    <label for="paginacion" class="mr-2">Productos por página:</label>
                                    <select name="paginacion" id="paginacion" wire:model="selectedPagination"
                                        wire:change="cambiarPaginado()"
                                        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                        <option value="0">Todas</option>
                                    </select>
                                </div>

                            </div>
                            <table id="data-table"
                                class="border border-black shadow-2xl mb-4 rounded-lg overflow-hidden"
                                style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                                <colgroup>
                                    <col style="width: 30%">
                                    <col style="width: 10%">
                                    <col style="width: 10%">
                                    <col style="width: 10%">
                                    <col style="width: 10%">
                                    <col style="width: 30%">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th class="bg-gray-800 text-white border border-white px-4 py-2">NOMBRE DEL
                                            PRODUCTO
                                            @if ($orders['nombre_producto'] == 0)
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('nombre_producto', '0')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            @elseif($orders['nombre_producto'] == 1)
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('nombre_producto', '1')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('nombre_producto', '2')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </th>
                                        <th class="bg-gray-800 text-white border border-white px-4 py-2">TIPO DE UNIDAD
                                        </th>
                                        <th class="bg-gray-800 text-white border border-white px-4 py-2">CATEGORIA
                                            @if ($orders['id_categoria'] == 0)
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('id_categoria', '0')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            @elseif($orders['id_categoria'] == 1)
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('id_categoria', '1')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('id_categoria', '2')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </th>
                                        <th class="bg-gray-800 text-white border border-white px-4 py-2">EXISTENCIAS
                                            @if ($orders['existencias'] == 0)
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('existencias', '0')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            @elseif($orders['existencias'] == 1)
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('existencias', '1')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button class="text-white font-bold py-1 px-1"
                                                    wire:click="ordenar('existencias', '2')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </th>
                                        <th class="bg-gray-800 text-white border border-white px-4 py-2">FOTO</th>
                                        <th class="bg-gray-800 text-white border border-white px-4 py-2">CANTIDAD A
                                            PEDIR</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productosA as $producto)
                                        <tr data-id="{{ $producto->id }}">
                                            <td class="border-b border-black px-4 py-2">
                                                {!! str_ireplace(
                                                    $inputBusqueda,
                                                    '<span class="bg-yellow-200 uppercase">' . $inputBusqueda . '</span>',
                                                    $producto->nombre_producto,
                                                ) !!}
                                            </td>
                                            <td class="border-b border-black px-4 py-2" style="justify-items:center">
                                                {{ $producto->unidad }}</td>
                                            <td class="border-b border-black px-4 py-2">
                                                {{ $producto->categoria->nombre_categoria }}</td>
                                            <td class="border-b border-black px-4 py-2">{{ $producto->existencias }}
                                            </td>
                                            <td class="border-b border-black px-4 py-2">
                                                @if ($producto->photo_prod != null)
                                                    <img src="{{ asset('imagen_productos/' . $producto->photo_prod) }} "
                                                        width="50ppx" id="imagenSeleccionada" max-width="50ppx"
                                                        max-height="50ppx" alt="Foto actual del producto">
                                                @else
                                                    <img src="{{ asset('imagen_productos/iconProduct.png') }}"
                                                        width="50ppx" id="imagenSeleccionada" max-width="50ppx"
                                                        max-height="50ppx" alt="Foto actual del producto">
                                                @endif
                                            </td>

                                            <td class="border-b border-black px-4 py-2">
                                                <div class="flex items-center justify-center">
                                                    @if ($carro->where('id', $producto->id)->count())
                                                        <form action="{{ route('cart.update') }}" method="POST"
                                                            enctype="multipart/form-data"
                                                            id="formCantidad{{ $producto->id }}"
                                                            class="place-content-center inline-flex rounded">
                                                            @csrf
                                                            <div>
                                                                <input type="hidden" name="row"
                                                                    value="{{ $carro->where('id', $producto->id) }}" />
                                                                {{ info($carro) }}
                                                                {{ info($producto->id) }}
                                                                <input type="number" name="cantidad"
                                                                    placeholder="Cantidad"
                                                                    class="rounded-lg text-sm sm:test-base ml-4 pr-4 w-2/3"
                                                                    value="{{ is_array($carro[$producto->id]) ? $carro[$producto->id]['qty'] : $carro[$producto->id]->qty }}"
                                                                    min="1" required />
                                                            </div>
                                                            <div class="rounded bg-blue-600 hover:bg-blue-700 mr-4">
                                                                <button type="submit"
                                                                    class="rounded text-white font-bold py-1 px-1 inline-flex">Cambiar
                                                                    cantidad
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="pr-2 h-7 w-7 place-self-center"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <!-- botón borrar -->
                                                        <form action="{{ route('cart.destroy') }}" method="POST"
                                                            id="formEliminar{{ $producto->id }}">
                                                            @csrf
                                                            <input type="hidden" name="row"
                                                                value="{{ $carro->where('id', $producto->id) }}" />
                                                            <div class="rounded bg-red-500 hover:bg-red-600 mr-4">
                                                                <button type="submit"
                                                                    class="rounded  text-white font-bold py-1 px-1 inline-flex">Borrar
                                                                    del carrito
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="pr-2 h-7 w-7 place-self-center"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <!-- botón agregar al carrito -->
                                                        <form action="{{ route('cart.store') }}" method="POST"
                                                            enctype="multipart/form-data"
                                                            id="formAgregar{{ $producto->id }}"
                                                            class="place-content-center inline-flex rounded">
                                                            @csrf
                                                            <div>
                                                                <input type="hidden" name="producto_id"
                                                                    value="{{ $producto->id }}" />
                                                                <input type="number" name="cantidad"
                                                                    placeholder="Cantidad"
                                                                    class="rounded-lg text-sm sm:test-base m-1 pr-1 w-8/12"
                                                                    min="1" required />
                                                                <input type="hidden" name="subareaDestino"
                                                                    wire:model="subDestino" />
                                                                <input type="hidden" name="almacen"
                                                                    value="{{ $almaceneseleccionado }}" />
                                                            </div>
                                                            <div class="rounded bg-blue-500 hover:bg-green-700">
                                                                <button type="submit"
                                                                    class="rounded text-white font-bold py-1 inline-flex w-11/12">Agregar
                                                                    al carrito
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="pl-2 h-7 w-7 place-self-center"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if ($flagDatos == false)
                                <div
                                    class="font-bold pl-2 text-gray-800 bg-gray-100 shadow-lg border border-gray-300 rounded-lg py-2 px-4 pd-4">
                                    No se Encontraron Datos</div>
                            @else
                                <div class="flex items-center justify-center pb-3">
                                    @if ($cantidadBotones < 6)
                                        @for ($i = 1; $i < $cantidadBotones + 1; $i++)
                                            @if ($i == $paginaSeleccionada)
                                                <button
                                                    class="bg-gray-300 hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2 "
                                                    wire:click="botonPaginadoSeleccionado({{ $i }})"
                                                    disabled>
                                                    {{ $i }}
                                                </button>
                                            @else
                                                <button
                                                    class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                    wire:click="botonPaginadoSeleccionado({{ $i }})">
                                                    {{ $i }}
                                                </button>
                                            @endif
                                        @endfor
                                    @else
                                        @if ($paginaSeleccionada > 2)
                                            <button
                                                class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                wire:click="botonPaginadoSeleccionado(1)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                                                </svg>
                                            </button>
                                        @else
                                            <button
                                                class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                wire:click="botonPaginadoSeleccionado(1)" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                                                </svg>
                                            </button>
                                        @endif

                                        @if ($paginaSeleccionada == 1)
                                            @for ($i = 1; $i < 4; $i++)
                                                @if ($i == $paginaSeleccionada)
                                                    <button
                                                        class="bg-gray-300 hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2 "
                                                        wire:click="botonPaginadoSeleccionado({{ $i }})"disabled>
                                                        {{ $i }}
                                                    </button>
                                                @else
                                                    <button
                                                        class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                        wire:click="botonPaginadoSeleccionado({{ $i }})">
                                                        {{ $i }}
                                                    </button>
                                                @endif
                                            @endfor
                                        @elseif ($paginaSeleccionada == $cantidadBotones)
                                            @for ($i = $paginaSeleccionada - 2; $i <= $paginaSeleccionada; $i++)
                                                @if ($i == $paginaSeleccionada)
                                                    <button
                                                        class="bg-gray-300 hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2 "
                                                        wire:click="botonPaginadoSeleccionado({{ $i }})"
                                                        disabled>
                                                        {{ $i }}
                                                    </button>
                                                @else
                                                    <button
                                                        class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                        wire:click="botonPaginadoSeleccionado({{ $i }})">
                                                        {{ $i }}
                                                    </button>
                                                @endif
                                            @endfor
                                        @elseif ($paginaSeleccionada < $cantidadBotones)
                                            @for ($i = $paginaSeleccionada - 1; $i < $paginaSeleccionada + 2; $i++)
                                                @if ($i == $paginaSeleccionada)
                                                    <button
                                                        class="bg-gray-300 hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2 "
                                                        wire:click="botonPaginadoSeleccionado({{ $i }})"
                                                        disabled>
                                                        {{ $i }}
                                                    </button>
                                                @else
                                                    <button
                                                        class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                        wire:click="botonPaginadoSeleccionado({{ $i }})">
                                                        {{ $i }}
                                                    </button>
                                                @endif
                                            @endfor
                                        @endif

                                        @if ($paginaSeleccionada < $cantidadBotones)
                                            <button
                                                class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                wire:click="botonPaginadoSeleccionado({{ $cantidadBotones }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                                                </svg>
                                            </button>
                                        @else
                                            <button
                                                class="bg-white hover:bg-gray-200 shadow-lg rounded-lg text-gray-700 font-bold border border-gray-500 py-2 px-4 ml-2"
                                                wire:click="botonPaginadoSeleccionado({{ $cantidadBotones }})"
                                                disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                                                </svg>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                        {{-- @livewire('inventarios-table') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
