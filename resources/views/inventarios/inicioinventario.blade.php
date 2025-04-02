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
                    @if (@Auth::user()->eid == '9JJGM' || @Auth::user()->can('producto.todosalmacenes'))
                        <!-- Inventario General -->
                        <div class="w-4 col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('productos.indexTotal') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-menu"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Inventario general</h4>
                                    <p class="description">Muestra el inventario total de la division Jalisco.</p>
                                </div>
                            </a>
                        </div>
                    @endif
                    <!-- Gestionar existencias -->
                     <!-- 
=======  Section =======
                    @can('producto.existencias')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('productos.eliminarExistenciasIndex') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx grid-alt"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm5 2h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4h-4V5zM3 20a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6zm2-5h4v4H5v-4zm8 5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6zm2-5h4v4h-4v-4z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Gestionar existencias</h4>
                                    <p class="description">Gestiona las existencias y mermas de los productos, así como el
                                        historial del producto.</p>
                                </div>
                            </a>
                        </div>
                    @endcan
                    ======= Hero =======-->
                    <!-- Crear Categorias -->
                    @can('inventario.categoria')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 ">
                            <a href="{{ route('categorias.create') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-collection"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19 10H5c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2zM5 20v-8h14l.002 8H5zM5 6h14v2H5zm2-4h10v2H7z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear categoría</h4>
                                    <p class="description">Crea categorías para los productos.</p>
                                </div>
                            </a>
                        </div>
                        <br><br><br>
                        <!-- Consultar Categorias-->
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('categorias.index') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-carousel"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M4 19h2c0 1.103.897 2 2 2h8c1.103 0 2-.897 2-2h2c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2h-2c0-1.103-.897-2-2-2H8c-1.103 0-2 .897-2 2H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2zM20 7v10h-2V7h2zM8 5h8l.001 14H8V5zM4 7h2v10H4V7z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Consultar categorías</h4>
                                    <p class="description">Consulta las categorías que has creado y realiza modificaciones.
                                        <b>Hay {{ $countCategorias }} categorías dadas de alta.</b>
                                    </p>
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

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contacto</h2>
                    <h3><span>Contáctanos</span></h3>
                    <p>Aquí podrás encontrar información para obtener ayuda y soporte</p>
                </div>

                <div class="row align-items-center justify-content-center" data-aos="fade-up"
                data-aos-delay="100">


                <a href="{{ route('soportes.create') }}" class="h-64 max-w-52 w-52 mx-1 px-3 py-1">
                    <div class="info-box max-w-52 h-64 w-52 mb-4 px-3 py-1">
                        <div class="px-3 py-1 d-flex align-items-center justify-content-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 31 31"
                                class="w-8 h-8 text-green-650">
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

            </div>
        </section><!-- End Contact Section -->

        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
        </body>
</x-app2>
