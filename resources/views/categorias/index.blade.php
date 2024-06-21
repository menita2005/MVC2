@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Formulario para crear una nueva categoría -->
    <br><br>
    <h1 class="fs-1" style="text-align: center;">Lista de Categorías</h1>

    <!-- Botón para agregar categoría, visible solo para admins -->
    @if(auth()->user()->usertype === 'admin')
    <button class="btn btn-primary mb-4" style="display: flex; justify-content: center;" onclick="document.getElementById('categoryForm').style.display='flex'">Agregar Categoría</button>
    @endif

    <br><br>
    <div style="display: flex; justify-content: center;">
        @if(!empty($categorias))
        <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    @if(auth()->user()->usertype === 'admin')
                    <th>Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                <tr>
                    <td>{{ $categoria['id'] }}</td>
                    <td>{{ $categoria['Nombre'] }}</td>
                    @if(auth()->user()->usertype === 'admin')
                    <td>
                        <!-- Botón de Editar -->
                        <button class="btn btn-primary mb-1" onclick="toggleEditForm({{ $categoria['id'] }})">Editar</button>
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
                                {{ $categoria['status'] ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                <!-- Formulario de Edición -->
                <tr id="editForm-{{ $categoria['id'] }}" style="display: none;">
                    <td colspan="3">
                        <form action="{{ route('categorias.update', $categoria['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="Nombre-{{ $categoria['id'] }}">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="Nombre-{{ $categoria['id'] }}" name="Nombre" value="{{ $categoria['Nombre'] }}" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Actualizar Categoría</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No hay categorías disponibles.</p>
        @endif
    </div>
    <!-- Formulario para agregar una nueva categoría -->
    <div id="categoryForm" style="display: none; justify-content: center;">
        <form action="{{ route('categorias.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="Nombre">Nombre de la Categoría</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Categoría</button>
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
