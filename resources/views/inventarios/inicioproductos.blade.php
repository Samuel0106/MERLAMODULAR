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
                    @if (@Auth::user()->can('producto.crear'))
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('productos.create') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-customize"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M4 11h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4H5V5zm15-2h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6zm-5-6h4v4H5v-4zm13-1h-2v2h-2v2h2v2h2v-2h2v-2h-2z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear producto</h4>
                                    <p class="description">Crea productos junto a su lugar de almacenamiento y sus
                                        existencias.</p>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if (@Auth::user()->can('producto.crear'))
                        <!-- Consultar Productos-->
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('productos.index') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-category"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4s4-1.794 4-4s-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2s2 .897 2 2s-.897 2-2 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Consultar productos</h4>
                                    <p class="description">Consulta los productos creados y realiza modificaciones.</p>
                                </div>
                            </a>
                        </div>
                    @endif
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
