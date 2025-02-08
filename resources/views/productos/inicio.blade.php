<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenidos a Inventarios') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">

            <img src="{{ asset('assets/bannerMerla.png') }}" alt="Logo MERLA" width="1088" height="262">

        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if (session()->has('message'))
                    <div class="px-2 inline-flex flex-row bg-blue-500 py-1 text-white" id="mssg-status">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session()->get('message') }}
                    </div>
                @elseif(session()->has('error'))
                    <div class="px-2 inline-flex flex-row bg-red-500 py-1 text-white" id="mssg-status">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="mt-8 bg-white  overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        @if (!@Auth::user()->hasRole('usuario'))
                            <!-- Crear Productos -->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Grid de cuadritos con un mas-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('productos.create') }}" class="underline text-gray-900">Crear
                                            Producto</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de la creacion de inventarios -->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Crea Productos junto a su lugar de almacenamiento y sus existencias.
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!@Auth::user()->hasRole('usuario'))
                            <!-- Consultar Productos-->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Grid de cuadritos-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('productos.index') }}"
                                            class="underline text-gray-900">Consultar Productos</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de consultar productos-->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Consulta los productos creados y realiza modificaciones.
                                        <!--<b>Hay {{ $productos }} productos dados de alta.</b>-->
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!@Auth::user()->hasRole('usuario'))
                            <!-- Ingresar Inventario -->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Grid de cuadritos-->

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('productos.indexI') }}"
                                            class="underline text-gray-900">Agregar
                                            Existencias</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de consultar productos-->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Ingresa existencias de productos ya registrados en el almacen.
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Eliminar existencias -->
                        <div class="p-6 border-b border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <!--Icono Grid de cuadritos con un mas-->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.8713 19.1213L16.9926 17M19.114 14.8787L16.9926 17M16.9926 17L14.8713 14.8787M16.9926 17L19.114 19.1213" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 9.4V4.6C4 4.26863 4.26863 4 4.6 4H9.4C9.73137 4 10 4.26863 10 4.6V9.4C10 9.73137 9.73137 10 9.4 10H4.6C4.26863 10 4 9.73137 4 9.4Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 19.4V14.6C4 14.2686 4.26863 14 4.6 14H9.4C9.73137 14 10 14.2686 10 14.6V19.4C10 19.7314 9.73137 20 9.4 20H4.6C4.26863 20 4 19.7314 4 19.4Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14 9.4V4.6C14 4.26863 14.2686 4 14.6 4H19.4C19.7314 4 20 4.26863 20 4.6V9.4C20 9.73137 19.7314 10 19.4 10H14.6C14.2686 10 14 9.73137 14 9.4Z" />
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a
                                        href="{{ route('productos.eliminarExistenciasIndex') }}"
                                        class="underline text-gray-900">Existencias consumidas</a></div>
                            </div>

                            <div class="ml-12">
                                <!--Descripción de la eliminacion de existencias -->
                                <div class="mt-2 text-gray-600 text-sm">
                                    Quita existencias y muestra el historial del producto.
                                </div>
                            </div>
                        </div>
                        <!-- Crear Categorias -->
                        @if (@Auth::user()->hasRole('admin'))
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Nota Apunte-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('categorias.create') }}"
                                            class="underline text-gray-900">Crear
                                            Categoría</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de la creacion de inventarios -->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Crea Categorías para los productos.
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (@Auth::user()->hasRole('admin'))
                            <!-- Consultar Categorias-->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono consultar categorias-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('categorias.index') }}"
                                            class="underline text-gray-900">Consultar
                                            Categorias</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de consultar productos-->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Consulta las categorías que has creado y realiza modificaciones.
                                        <b>Hay {{ $countCategorias }} categorías dadas de alta.</b>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Solicitar productos -->
                        <div class="p-6 border-b border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <!--Icono Nota Apunte-->
                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    class="w-8 h-8 text-gray-500">
                                    <path
                                        d="M3,5 v16 h13 l4,-4 v-11 m-3,-1 h-14 M16,21 v-4 h4 M9,15 l2,0 l11,-11 l-2,-2 l-11,11 l0,2">
                                    </path>
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a
                                        href="{{ route('inventarios.create') }}" class="underline text-gray-900">
                                        Solicitar Producto</a></div>
                            </div>

                            <div class="ml-12">
                                <!--Descripción de la creacion de inventarios -->
                                <div class="mt-2 text-gray-600 text-sm">
                                    @if (@Auth::user()->hasRole('usuario'))
                                        Solicita productos a su almacen correspondiente.
                                    @else
                                        Solicita productos al almacen.
                                    @endif
                                </div>
                            </div>
                        </div>






                        <!-- Consultar Inventarios-->
                        <div class="p-6 border-b border-gray-200 md:border-l">
                            <div class="flex items-center">
                                <!--Icono Nota Apunte-->
                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                    class="w-8 h-8 text-gray-500">
                                    <path
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a
                                        href="{{ route('inventarios.index') }}"
                                        class="underline text-gray-900">Consultar mis pedidos</a></div>
                            </div>

                            <div class="ml-12">
                                <!--Descripción de consultar inventarios-->
                                <div class="mt-2 text-gray-600 text-sm">
                                    Consulta el TOTAL de pedidos que has creado y realiza modificaciones.
                                    <b>Usted ha realizado {{ $countPedidos }} pedidos.</b>
                                </div>
                            </div>
                        </div>
                        @can('inventarios.autorizar')
                            <!-- Autorizar inventarios -->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Clipboard con una palomita-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('inventarios.autorizar') }}"
                                            class="underline text-gray-900">Autorizar Pedidos</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de la autorizacion de inventarios -->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Autoriza pedidos que esten pendientes.
                                        @if ($countPendientes == 0)
                                            <b>No hay pedidos pendientes.</b>
                                        @else
                                            @if ($countPendientes == 1)
                                                <b class="text-green-600">Hay {{ $countPendientes }} pedido pendiente.</b>
                                            @else
                                                <b class="text-green-600">Hay {{ $countPendientes }} pedidos pendientes.</b>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @can('inventarios.entregar')
                            <!-- Entregar solicitudes-->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Camion-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('inventarios.entregar') }}"
                                            class="underline text-gray-900">Entregar productos en centros de
                                            trabajo</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de entrega de productos-->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Entrega pedidos que esten autorizados.
                                        @if ($countAutorizados == 0)
                                            <b>No hay pedidos autorizados.</b>
                                        @else
                                            <b class="text-green-600">Hay {{ $countAutorizados }} pedidos autorizados.</b>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Camion-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"
                                        class="h-8 w-8 text-gray-500">
                                        <path
                                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('inventarios.entregados') }}"
                                            class="underline text-gray-900">Pedidos Entregados</a></div>
                                </div>
                                <div class="ml-12">
                                    <!--Descripción de entrega de productos-->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Muestra todos los pedidos que han sido entregados.
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @if (@Auth::user()->hasRole('JefeInventario'))
                            <!-- Consultar Productos-->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Grid de cuadritos-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('almacenes.index') }}"
                                            class="underline text-gray-900">Almacenes</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de consultar productos-->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Habilita o deshabilita almacenes.
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (@Auth::user()->hasRole('JefeInventario'))
                            <!-- Autorizar inventarios -->
                            <div class="p-6 border-b border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <!--Icono Clipboard con una palomita-->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <div class="ml-4 text-lg leading-7 font-semibold"><a
                                            href="{{ route('mermas.index') }}"
                                            class="underline text-gray-900">Mermas</a></div>
                                </div>

                                <div class="ml-12">
                                    <!--Descripción de la autorizacion de inventarios -->
                                    <div class="mt-2 text-gray-600 text-sm">
                                        Autoriza y muestra todas las mermas.
                                        @if ($countMermas == 0)
                                            <b>No hay mermas por autorizar.</b>
                                        @else
                                            <b class="text-green-600">Hay {{ $countMermas }} reportes de merma
                                                pendientes.</b>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="mt-8 bg-white  overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">

                        <div class="p-6 border-t border-gray-200  md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 31 31"
                                    class="w-8 h-8 text-gray-500">
                                    <path d="M16,12a2,2,0,1,1,2-2A2,2,0,0,1,16,12Zm0-2Z" />
                                    <path
                                        d="M16,29A13,13,0,1,1,29,16,13,13,0,0,1,16,29ZM16,5A11,11,0,1,0,27,16,11,11,0,0,0,16,5Z" />
                                    <path d="M16,24a2,2,0,0,1-2-2V16a2,2,0,0,1,4,0v6A2,2,0,0,1,16,24Zm0-8v0Z" />
                                </svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a
                                        href="{{ route('soportes.create') }}"
                                        class="underline text-gray-900 ">Soporte</a></div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
