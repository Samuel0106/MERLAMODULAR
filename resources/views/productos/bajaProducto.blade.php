<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quitar Existencias de ' . Str::of($producto->nombre_prod) . ', ' . Str::of($subarea_nombre)) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form action="{{ route('productos.actualizarExistencias', $producto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-5 md:gap-8 mt-5 mx-7">
                    <div>
                        <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Existencias Actuales:</label>
                        <input name="Exist" class="py-2 px-2 w-16 rounded-lg border-2 border-green-800 mt-3 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" disabled value={{ App\Models\Producto::where('id', $producto->id)->first()->existencias}} />
                    </div>

                        <div>
                            <label
                                class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Cantidad a quitar:</label>
                            <input name="existencias"
                                class="py-2 w-full  rounded-lg border-2 border-blue-600 mt-3 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent"
                                type="number" value="{{ old('existencias') ?? '' }}" required  min=1 max={{ App\Models\Producto::where('id', $producto->id)->first()->existencias}} step=1 />
                            @error('existencias')
                                <span style="font-size: 10pt;color:red" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>

                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Reporte de evidencia:</label>
                            <input type="file" name="archivo" class="py-2 w-full mt-1 mr-3 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent" required />
                        </div>
                    </div>

                    <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                        <a href="{{ route('productos.eliminarExistenciasIndex') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancelar</a>
                        <button type="submit"
                            class='w-auto bg-blue-500 hover:bg-blue-600 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>


<!-- Script para ver la imagen antes de CREAR UN NUEVO PRODUCTO -->
<script src={{ asset('plugins/jquery/jquery-3.5.1.min.js') }}></script>
