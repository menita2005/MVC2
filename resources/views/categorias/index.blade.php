@extends('layouts.app')

@section('content')
<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
    <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Lista de Categorías</h1>

    <br><br>
    <div class="table-responsive">
        @if(!empty($categorias))
        <div class="flex justify-center">
        <table class="table-auto w-3/4 mb-4 center">
            <thead>
                <tr>
                    @if(auth()->user()->usertype === 'admin')
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">ID</th>
                    @endif
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Nombre</th>
                    @if(auth()->user()->usertype === 'admin')
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                <tr>
                    @if(auth()->user()->usertype === 'admin')
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $categoria['id'] }}</td>
                    @endif
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $categoria['Nombre'] }}</td>
                    @if(auth()->user()->usertype === 'admin')
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">
                        <!-- Botón de Editar -->
                        <a href="{{ route('categorias.edit', $categoria['id']) }}" class="btn btn-primary mb-1" style="background-color: #ffc600; color: #FFFFFF;">Editar</a>
                        <!-- Formulario de Eliminar -->
                        <form action="{{ route('categorias.destroy', $categoria['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">Eliminar</button>
                        </form>
                        <!-- Botón de Activar/Desactivar -->
                        <form action="{{ route('categorias.toggleStatus', $categoria['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary mt-1">
                                {{ $categoria['status']? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                <div id="providerForm" style="display: none; justify-content: center;">
                <!-- Formulario de Edición -->
                <tr id="editForm-{{ $categoria['id'] }}" style="display: none;">
                    <td colspan="3">
                        <form action="{{ route('categorias.update', $categoria['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="Nombre-{{ $categoria['id'] }}" class="text-lg font-bold">Nombre de la Categoría</label>
                                <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="Nombre-{{ $categoria['id'] }}" name="Nombre" value="{{ $categoria['Nombre'] }}" required>
                            </div>
                            <button type="submit" class="btn btn-success w-full p-2 pl-10 text-sm text-white mt-3">Actualizar Categoría</button>
                        </form>
                    </td>
                </tr>
                </div>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-lg font-bold text-center">No hay categorías disponibles.</p>
        @endif
    </div>

    <!-- Botón para agregar categoría, visible solo para admins -->
    @if(auth()->user()->usertype === 'admin')
    <div class="text-center">

    <button class="btn btn-primary mb-4" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;" onclick="document.getElementById('categoryForm').style.display='flex'">Agregar Categoría</button>
</div>
    @endif

  <!-- Formulario para agregar una nueva categoría -->
<div id="categoryForm" style="display: none; justify-content: center;">
    <div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">

        <form action="{{ route('categorias.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group mb-4">
                <label for="Nombre" class="text-lg font-bold block mb-2">Nombre de la Categoría</label>
                <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md" id="Nombre" name="Nombre" required>
            </div>
            <div class="text-center">

            <button type="submit" class="btn btn-primary mb-4" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;">Guardar Categoría</button>
</div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleEditForm(categoryId) {
        var form = document.getElementById('editForm-' + categoryId);
        if (form.style.display === 'none') {
            form.style.display = 'table-row';
        } else {
            form.style.display = 'none';
        }
    }
</script>
@endpush