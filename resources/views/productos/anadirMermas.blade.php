<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            {{ __('Añadir mermas de ' . $producto->nombre_producto . ', en ' . $producto->ubicacion) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('mermas.store', $producto->id) }}" id="formMerma" class="formBajar" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-5 md:gap-8 mt-5 mx-7">
                        <div>
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Existencias Actuales:</label>
                            <input name="Exist" class="py-2 px-2 w-20 text-center rounded-lg border-2 border-green-800 mt-3 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" disabled value={{ App\Models\Producto::where('id', $producto->id)->first()->existencias}} />
                        </div>

                        <div>
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cantidad a añadir como merma:</label>
                            <input oninput="validarNumero()" id="cant_id" name="cantidad" class="py-2 w-full  rounded-lg border-2 border-blue-600 mt-3 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" type="number" value="{{ old('cantidad') ?? '' }}" required min=1 max={{ $producto->existencias}} step=1 />
                            <input hidden name='producto' value={{$producto->id}} />
                            <input id="existencias" type="number" value="{{$producto->existencias}}" hidden>
                            <div id="mensajeError"></div>
                        </div>
                        <div>

                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Reporte de evidencia:</label>
                            <input type="file" name="archivo" class="py-2 w-full mt-1 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required />
                        </div>
                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('productos.eliminarExistenciasIndex') }}" class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit" class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
<script>
    function validarNumero() {
        // Obtener el valor ingresado por el usuario
        var numero = parseInt(document.getElementById("cant_id").value);
        var existencias = parseInt(document.getElementById("existencias").value);
        // Comprobar si el valor es un número válido        
        if (numero != null) {
            if (numero < 1 || numero > existencias) {
                mostrarMensajeError("La cantidad debe ser un valor entre 1 y " + existencias);
            } else {
                // Si el valor es válido, borrar el mensaje de error (si existe)
                ocultarMensajeError();
            }
        }
    }

    function mostrarMensajeError(mensaje) {
        const mensajeErrorDiv = document.getElementById("mensajeError");
        mensajeErrorDiv.textContent = mensaje;
        mensajeErrorDiv.style.color = "red";

        // Desaparecer el mensaje de error después de 3 segundos
        /* setTimeout(() => {
            ocultarMensajeError();
        }, 3000); */
    }

    function ocultarMensajeError() {
        const mensajeErrorDiv = document.getElementById("mensajeError");
        mensajeErrorDiv.textContent = "";
    }
</script>

<script>    
    document.getElementById("formMerma").addEventListener("submit", function(event) {
        var loader = document.getElementById("preloader"); //Se guarda el loader en la variable.
        event.preventDefault(); // Evita que el formulario se envíe automáticamente

        // Muestra SweetAlert de confirmación
        Swal.fire({
            title: '¿Confirma este cambio?',
            text: 'No podrá deshacer esta acción.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, realizar cambios',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#20c997',
            cancelButtonColor: '#6c757d',
            reverseButtons: true
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    // Realizar la petición AJAX para enviar el formulario al servidor
                    const formElement = document.getElementById("formMerma");
                    const formData = new FormData(formElement);

                    const response = await fetch('/storeMerma', {
                        method: 'POST',
                        body: formData
                    });

                    if (response.ok) {
                        // El servidor respondió correctamente, mostrar SweetAlert de éxito y redireccionar
                        Swal.fire({
                            title: '¡Cambios realizados!',
                            text: 'Los cambios han sido guardados correctamente.',
                            icon: 'success'
                        }).then(() => {
                            // Redireccionar a la ruta de Laravel después de mostrar la notificación de éxito
                            window.location.href = '/mermas';
                        });
                    } else {
                        // El servidor respondió con un error, mostrar SweetAlert de error
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al guardar los cambios en la base de datos.',
                            icon: 'error'
                        });
                    }
                } catch (error) {
                    console.error('Error al enviar el formulario:', error);
                }
            }
            else{
                loader.style.display = "none";
            }
        });
    });
</script>