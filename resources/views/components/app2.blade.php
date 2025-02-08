<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield ('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href={{asset('plugins/googleapis/css2.css')}}>
        <link href={{asset('plugins/tailwind/tailwind.min.css')}} rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
        <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">

        {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap/css/bootstrap.min.css')}}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-icons/bootstrap-icons.css')}}"> --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/boxicons/boxicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/glightbox/glightbox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/aos/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('css/swiper/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @yield('css')

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    </head>
    <body class="font-sans antialiased">
        <div id="preloader"></div>
        <x-jet-banner />
        

        <div class="min-h-screen">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        @livewireChartsScripts
        <script src={{asset('plugins/livewire/sweetalert2@11.js')}}></script>
        <script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('js/preloader.js') }}"></script>
        <script src="{{ asset('js/purecounter/purecounter_vanilla.js') }}"></script>
        <script src="{{ asset('js/aos/aos.js') }}"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/glightbox/glightbox.min.js') }}"></script>
        <script src="{{ asset('js/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('js/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery-min.js') }}"></script>
        <script>
            AOS.init();
        </script>
        <!-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->
        @yield('js')
        
    </body>
</html>


