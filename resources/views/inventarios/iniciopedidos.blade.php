<x-app2>
    @section('title', 'PLANTILLA - MERLA')

    <!--
======= Hero Section =======
    <section id="hero" class="d-flex align-items-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>Inicio <span>MERLA</span></h1>
            <h2>
                Manejo y Estrategia de Registros para Logística y Almacenes.<br><br>
                Controla tus productos, organiza categorías, genera pedidos y monitorea su estado en tiempo real.
            </h2>
            <blockquote>
                "La excelencia logística comienza con el trabajo en equipo y una gestión eficiente."
            </blockquote>
            <div class="d-flex">
                <a href="#featured-services" class="btn-get-started scrollto"><b>Sistemas</b></a>
            </div>
        </div>
    </section> ======= End Hero =======-->
    <main id="main">
        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services" href="#services">
            <div class="container" data-aos="fade-up">

                @if (session()->has('message'))
                    <div class="px-2 inline-flex flex-row bg-blue-500 py-1 text-white mb-2 rounded-lg" id="mssg-status">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session()->get('message') }}
                    </div>
                @elseif(session()->has('error'))
                    <div class="px-2 inline-flex flex-row bg-red-600 py-1 text-white mb-2 rounded-lg" id="mssg-status">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-flex" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session()->get('error') }}
                    </div>
                @endif

                @php
                    $delay = 0;
                    $espacio = 100;
                    $max = 400;
                @endphp
                <div class="row">
                    <!-- Solicitar productos -->
                    <div class="col-md-6 col-lg-3  d-flex align-items-stretch mb-5">
                        <a href="{{ route('inventarios.create') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-add-to-queue"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M20 2H8c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM8 16V4h12l.002 12H8z" />
                                        <path fill="currentColor"
                                            d="M4 8H2v12c0 1.103.897 2 2 2h12v-2H4V8zm11-2h-2v3h-3v2h3v3h2v-3h3V9h-3z" />
                                    </svg>
                                </div>
                                <h4 class="title">Solicitar producto</h4>
                                <p class="description">
                                    @if (@Auth::user()->hasRole('usuario'))
                                        Solicita productos a su almacen correspondiente.
                                    @else
                                        Solicita productos al almacen.
                                    @endif
                                </p>
                            </div>
                        </a>
                    </div>
                    <!-- Solicitar pedido especial -->
                    <div class="col-md-6 col-lg-3  d-flex align-items-stretch mb-5">
                        <a href="{{ route('inventarios.pedidoespecial') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-add-to-queue"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M20 2H8c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM8 16V4h12l.002 12H8z" />
                                        <path fill="currentColor"
                                            d="M4 8H2v12c0 1.103.897 2 2 2h12v-2H4V8zm11-2h-2v3h-3v2h3v3h2v-3h3V9h-3z" />
                                    </svg>
                                </div>
                                <h4 class="title">Solicitar pedido especial</h4>
                                <p class="description">
                                    Solicituar un producto que no exista en el inventario
                                </p>
                            </div>
                        </a>
                    </div>
                    <!-- Consultar Inventarios-->
                    <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                        <a href="{{ route('inventarios.index') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-basket"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M21 9h-1.42l-3.712-6.496l-1.736.992L17.277 9H6.723l3.146-5.504l-1.737-.992L4.42 9H3a1.001 1.001 0 0 0-.965 1.263l2.799 10.264A2.005 2.005 0 0 0 6.764 22h10.473c.898 0 1.692-.605 1.93-1.475l2.799-10.263A.998.998 0 0 0 21 9zm-3.764 11v1v-1H6.764L4.31 11h15.38l-2.454 9z" />
                                        <path fill="currentColor" d="M9 13h2v5H9zm4 0h2v5h-2z" />
                                    </svg>
                                </div>
                                <h4 class="title">Consultar mis pedidos</h4>
                                <p class="description">Consulta el TOTAL de pedidos que has creado y realiza
                                    modificaciones.
                                    @if ($countPedidos == 1)
                                        <b>Usted ha realizado {{ $countPedidos }} pedido.</b>
                                    @else
                                        <b>Usted ha realizado {{ $countPedidos }} pedidos.</b>
                                    @endif
                                </p>
                            </div>
                        </a>
                    </div>
                    <!-- Autorizar inventarios -->
                    @can('inventario.autorizar')
                        <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('inventarios.autorizar') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-check-square"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m10.933 13.519l-2.226-2.226l-1.414 1.414l3.774 3.774l5.702-6.84l-1.538-1.282z" />
                                            <path fill="currentColor"
                                                d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM5 19V5h14l.002 14H5z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Autorizar pedidos</h4>
                                    <p class="description">Autoriza pedidos que esten pendientes.
                                        @if ($countPendientes == 0)
                                            <b>No hay pedidos pendientes.</b>
                                        @else
                                            @if ($countPendientes == 1)
                                                <b>Hay {{ $countPendientes }} pedido pendiente</b>
                                            @else
                                                <b>Hay {{ $countPendientes }} pedidos pendientes.</b>
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endcan

                    <!-- Autorizar Pedidos Especiales -->
                    @can('inventario.authPedidoEspecial')
                        <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('inventarios.indexPedidoEspecial') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-check-double"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m2.394 13.742l4.743 3.62l7.616-8.704l-1.506-1.316l-6.384 7.296l-3.257-2.486zm19.359-5.084l-1.506-1.316l-6.369 7.279l-.753-.602l-1.25 1.562l2.247 1.798z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Autorizar pedidos especiales</h4>
                                    <p class="description">Muestra los pedidos especiales para autorizarlos.</p>
                                </div>
                            </a>
                        </div>
                    @endcan
                    <!-- Entregar solicitudes-->
                    @can('inventario.entregar')
                        <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('inventarios.entregar') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-package"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16a.35.35 0 0 0-.05-.08l-.1-.13l-.08-.06l-.12-.09l-9-5a1 1 0 0 0-1 0l-9 5l-.09.07l-.11.08a.41.41 0 0 0-.07.11a.39.39 0 0 0-.08.1a.59.59 0 0 0-.06.14a.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06l9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52l6.83 3.9zm0-7.72L18.94 8L16.7 9.25L9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Entregar productos en centros de trabajo</h4>
                                    <p class="description">Entrega pedidos que esten autorizados.
                                        @if ($countAutorizados == 0)
                                            <b>No hay pedidos autorizados.</b>
                                        @else
                                            @if ($countAutorizados == 1)
                                                <b class="text-green-600">Hay {{ $countAutorizados }} pedido
                                                    autorizado.</b>
                                            @else
                                                <b class="text-green-600">Hay {{ $countAutorizados }} pedidos
                                                    autorizados.</b>
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                        <!-- Entregar pedidos-->
                        <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('inventarios.entregados') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-list-check"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M4 7h11v2H4zm0 4h11v2H4zm0 4h7v2H4zm15.299-2.708l-4.3 4.291l-1.292-1.291l-1.414 1.415l2.706 2.704l5.712-5.703z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Pedidos entregados</h4>
                                    <p class="description">Muestra todos los pedidos que han sido entregados.</p>
                                </div>
                            </a>
                        </div>
                    @endcan


                    {{-- @can('inventarios.reponer')
                        <!-- Reponer producto -->
                        <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <div class="icon-box service-box" data-aos="fade-up" data-aos-delay="{{$delay=($delay%$max)+$espacio}}">
                                <div class="icon">
                                    <!-- <i class="bx bx-x"></i> -->
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M13 5h9v2h-9zM2 7h7v2h2V3H9v2H2zm7 10h13v2H9zm10-6h3v2h-3zm-2 4V9.012h-2V11H2v2h13v2zM7 21v-6H5v2H2v2h3v2z"/>
                                    </svg>
                                </div>
                                <h4 class="title"><a href="{{ route('inventarios.reponer') }}">Reponer producto</a></h4>
                                <p class="description">Mustra los productos que han sido solicitados para reponerlos.</p>
                            </div>
                        </div>
                    @endcan --}}
                </div>

            </div>
        </section><!-- End Featured Services Section -->

        {{--
<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Contacto</h2>
            <h3><span>Contáctanos</span></h3>
            <p>Aquí podrás encontrar información para obtener ayuda y soporte</p>
        </div>

        <div class="row align-items-center justify-content-center" data-aos="fade-up" data-aos-delay="100">

            <a href="{{ route('soportes.create') }}" class="h-64 max-w-52 w-52 mx-1 px-3 py-1">
                <div class="info-box max-w-52 h-64 w-52 mb-4 px-3 py-1">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewBox="0 0 31 31" class="w-8 h-8 text-green-650">
                            <path d="M16,12a2,2,0,1,1,2-2A2,2,0,0,1,16,12Zm0-2Z" />
                            <path
                                d="M16,29A13,13,0,1,1,29,16,13,13,0,0,1,16,29ZM16,5A11,11,0,1,0,27,16,11,11,0,0,0,16,5Z" />
                            <path d="M16,24a2,2,0,0,1-2-2V16a2,2,0,0,1,4,0v6A2,2,0,0,1,16,24Zm0-8v0Z" />
                        </svg>
                    </div>
                    <h3>Soporte</h3>
                    <p>Déjanos tus dudas o comentarios</p>
                </div>
            </a>
        </div>

    </div>
</section>
--}}


        </div>
        </section><!-- End Contact Section -->

        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
        </body>
</x-app2>
