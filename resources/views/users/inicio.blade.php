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

                @php
                    $delay = 0;
                    $espacio = 100;
                    $max = 400;
                @endphp
                <div class="row">
                    <!-- Gestión -->
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                        <a href="{{ route('users.index') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-group"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M16.604 11.048a5.67 5.67 0 0 0 .751-3.44c-.179-1.784-1.175-3.361-2.803-4.44l-1.105 1.666c1.119.742 1.8 1.799 1.918 2.974a3.693 3.693 0 0 1-1.072 2.986l-1.192 1.192l1.618.475C18.951 13.701 19 17.957 19 18h2c0-1.789-.956-5.285-4.396-6.952z" />
                                        <path fill="currentColor"
                                            d="M9.5 12c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2zm1.5 7H8c-3.309 0-6 2.691-6 6v1h2v-1c0-2.206 1.794-4 4-4h3c2.206 0 4 1.794 4 4v1h2v-1c0-3.309-2.691-6-6-6z" />
                                    </svg>
                                </div>
                                <h4 class="title">Gestión</h4>
                                <p class="description">En este enlace podrás administrar los usuarios que se encuentran
                                    dentro del sistema.</p>
                            </div>
                        </a>
                    </div>
                    <!-- Roles -->
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                        <a href="{{ route('roles.index') }}" class="card-link">
                            <div class="icon-box service-box" data-aos="fade-up"
                                data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                <div class="icon">
                                    {{-- <i class="bx bx-user-circle"></i> --}}
                                    <svg class="iconos" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12 2A10.13 10.13 0 0 0 2 12a10 10 0 0 0 4 7.92V20h.1a9.7 9.7 0 0 0 11.8 0h.1v-.08A10 10 0 0 0 22 12A10.13 10.13 0 0 0 12 2zM8.07 18.93A3 3 0 0 1 11 16.57h2a3 3 0 0 1 2.93 2.36a7.75 7.75 0 0 1-7.86 0zm9.54-1.29A5 5 0 0 0 13 14.57h-2a5 5 0 0 0-4.61 3.07A8 8 0 0 1 4 12a8.1 8.1 0 0 1 8-8a8.1 8.1 0 0 1 8 8a8 8 0 0 1-2.39 5.64z" />
                                        <path fill="currentColor"
                                            d="M12 6a3.91 3.91 0 0 0-4 4a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2a1.91 1.91 0 0 1 2-2a1.91 1.91 0 0 1 2 2a1.91 1.91 0 0 1-2 2z" />
                                    </svg>
                                </div>
                                <h4 class="title">Roles</h4>
                                <p class="description">Administración de roles para los usuarios.</p>
                            </div>
                        </a>
                    </div>
                    <!--Crear-->
                    @can('users.create')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('users.create') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-user-plus"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM4 8a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4a3.91 3.91 0 0 0-4 4zm6 0a1.91 1.91 0 0 1-2 2a1.91 1.91 0 0 1-2-2a1.91 1.91 0 0 1 2-2a1.91 1.91 0 0 1 2 2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Crear</h4>
                                    <p class="description">Aquí podrás crear nuevos usuarios para el sistema.</p>
                                </div>
                            </a>
                        </div>
                    @endcan
                    <!-- Usuarios dados de baja -->
                    @can('users.baja')
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5">
                            <a href="{{ route('users.usuariosBaja') }}" class="card-link">
                                <div class="icon-box service-box" data-aos="fade-up"
                                    data-aos-delay="{{ $delay = ($delay % $max) + $espacio }}">
                                    <div class="icon">
                                        {{-- <i class="bx bx-user-minus"></i> --}}
                                        <svg class="iconos" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M14 11h8v2h-8zM8 4a3.91 3.91 0 0 0-4 4a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2a1.91 1.91 0 0 1 2-2a1.91 1.91 0 0 1 2 2a1.91 1.91 0 0 1-2 2zm-4 8a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z" />
                                        </svg>
                                    </div>
                                    <h4 class="title">Baja</h4>
                                    <p class="description">Aquí podrás ver los usuarios dados de baja.</p>
                                </div>
                            </a>
                        </div>
                    @endcan
                    </div>
                </div>
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
