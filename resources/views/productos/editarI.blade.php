<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Añadir Existencias: ' . Str::of($producto->nombre_producto) . ', ' . Str::of($subarea_nombre)) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('productos.updateAgregarExistencias', $producto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-5 md:gap-8 mt-5 mx-7">

                        <div>
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Ingresar existencias:</label>
                            <input name="existencias" class="py-2 w-full  rounded-lg border-2 border-blue-600 mt-3 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="number" min="1" max="100000" value="{{ old("existencias") ?? '' }}" required />
                            @error('existencias')
                            <span style="font-size: 10pt;color:red" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ url()->previous() }}" class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    var loader = document.getElementById("preloader");
    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Existencias guardadas exitosamente',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    loader.style.display = "none";
                    if (result.isConfirmed) {
                        window.location.href = "/productos/inventario/eliminar";
                    }
                });
            }
        });
    });
</script>