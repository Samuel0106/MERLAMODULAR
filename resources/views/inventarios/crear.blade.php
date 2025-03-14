<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Solicitud de Productos') }}
        </h2>
    </x-slot>

    <head>
        @section('css')
            <link rel="stylesheet" href="{{ asset('css/switchButton.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
            <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}">
            <link rel="stylesheet" href="{{ asset('css/preloader-livewire.css') }}">
        @endsection
        @livewireStyles
    </head>

    <body>
    <?php
        $subareaSel;
        $almacenes;
        if(isset($_GET['subareaSel'])){
            $subareaSel = $_GET['subareaSel'];
        }else{
            $subareaSel = "";
        }
        if(isset($_GET['almacenes'])){
            $almacenes = $_GET['almacenes'];
        }else {
            $almacenes = "";
        }
        ?>
        @livewire('inventarios-create', ['almacenes'=> $almacenes, 'subareaSel'=> $subareaSel,'user' => $user, 'carro' => $carro, 'productos' => $productos, 'datos' => $datos])
        @livewireScripts
        @livewireChartsScripts
        @section('js')
        <!--<script src="{{ asset('plugins/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/dataTables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/customDataTables.js') }}"></script>-->
        <script>
            $(document).ready(function() {
                $('.openModal').on('click', function(e) {
                    $('#interestModal').removeClass('invisible');
                });
                $('.closeModal').on('click', function(e) {
                    $('#interestModal').addClass('invisible');
                });
                const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
                var SITEURL = "{{ url('/') }}";
                <?php foreach ($productos as $producto) { ?>
                $("#formAgregar{{ $producto->id }}").submit(function(event) {
                    console.log(event);
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Seguro que quieres agregarlo al carrito?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formAgregar{{ $producto->id }}').submit();
                        } else{
                            window.location.href = '/inventarios/create';
                        }
                    });
                });
                $("#formCantidad{{ $producto->id }}").submit(function(event) {
                    console.log(event);
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Seguro que quieres cambiar la cantidad?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formCantidad{{ $producto->id }}').submit();
                        }else{
                            loader.style.display = "none";
                        }
                    });
                });
                $("#formEliminar{{ $producto->id }}").submit(function(event) {
                    console.log(event);
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Seguro que quieres eliminarlo del carrito?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: '¡Eliminado con exito!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            }).then((result) => {
                                document.getElementById('formEliminar{{ $producto->id }}')
                                    .submit();
                            });
                        }
                        //Se oculta el loader para que no tape toda la pantalla por siempre.
                        else{
                            loader.style.display = "none";
                        }
                    });
                });
                <?php } ?>
            });
        </script>

        <script>
            function guardarInventario() {
                <?php if (\Gloudemans\Shoppingcart\Facades\Cart::content()->count() === 0) : ?>
                Swal.fire({
                    title: '¡No hay productos en el carrito!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                })
                <?php else : ?>
                Swal.fire({
                    title: '¡Guardado con exito!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    document.getElementById('formGuardar').submit();
                })
                <?php endif; ?>
            }
        </script>
        <script>
            var dateStart = document.getElementById("dateStart");
            
            var fechaActual = new Date();

            function esSabado(fecha) {
                return fecha.getDay() === 5;              
            }
            function esDomingo(fecha){     
                return fecha.getDay() === 6;
            }
            
            var fechaMin;
            if (esSabado(new Date(fechaActual.getTime() + (3 * 24 * 60 * 60 * 1000)))) {
                fechaMin = new Date(fechaActual.getTime() + (5 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
            } 
            else if (esDomingo(new Date(fechaActual.getTime() + (3 * 24 * 60 * 60 * 1000)))) {
                fechaMin = new Date(fechaActual.getTime() + (4 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
            } 
            else {
                fechaMin = new Date(fechaActual.getTime() + (3 * 24 * 60 * 60 * 1000)).toISOString().slice(0, 10);
            }

            var fechaMax = new Date(fechaActual.getTime() + (30 * 24 * 60 * 60 * 1000)).toISOString().slice(0,10);

            dateStart.setAttribute('min', fechaMin);
            dateStart.setAttribute('max', fechaMax)

            dateStart.onchange = function() {
            var selectedDate = new Date(dateStart.value);
                if (selectedDate.getDay() === 5 || selectedDate.getDay() === 6) {
                    alert('No se puede seleccionar Sabado o Domingo');
                    dateStart.value = fechaMin;
                }
            }

            dateStart.value = fechaMin;
        </script>
    @endsection
    </body>
</x-app-layout>
