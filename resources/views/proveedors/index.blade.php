@extends('layouts.app')

@section('content')
<body>
    <!-- Formulario para crear un nuevo proveedor -->
    <br><br>
    <h1 class="fs-1" style="text-align: center;">Lista de Proveedores</h1>
    <button class="btn btn-primary" style="display: flex; justify-content: center;" onclick="document.getElementById('providerForm').style.display='flex'">Agregar Proveedor</button>

    <br><br>
    <div style="display: flex; justify-content: center;">
        <table border="1" style="border-collapse: collapse; width: 80%;">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
            @foreach ($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor['id'] }}</td>
                <td>{{ $proveedor['nombre'] }}</td>
                <td>{{ $proveedor['correo'] }}</td>
                <td>{{ $proveedor['telefono'] }}</td>
                <td>{{ $proveedor['direccion'] }}</td>
                <td>
                    <!-- Botón de Editar -->
                    <button class="btn btn-primary" onclick="toggleEditForm({{ $proveedor['id'] }})">Editar</button>
                    <!-- Formulario de Eliminar -->
                    <form action="{{ route('proveedors.destroy', $proveedor['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?')">Eliminar</button>
                    </form>
                </td>
                <!-- Formulario de Edición -->
                <tr id="editForm-{{ $proveedor['id'] }}" style="display: none;">
                    <td colspan="6">
                        <form action="{{ route('proveedors.update', $proveedor['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nombre-{{ $proveedor['id'] }}">Nombre del Proveedor</label>
                                <input type="text" class="form-control" id="nombre-{{ $proveedor['id'] }}" name="nombre" value="{{ $proveedor['nombre'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="correo-{{ $proveedor['id'] }}">correo</label>
                                <input type="text" class="form-control" id="correo-{{ $proveedor['id'] }}" name="correo" value="{{ $proveedor['correo'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono-{{ $proveedor['id'] }}">Teléfono</label>
                                <input type="text" class="form-control" id="telefono-{{ $proveedor['id'] }}" name="telefono" value="{{ $proveedor['telefono'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="direccion-{{ $proveedor['id'] }}">Dirección</label>
                                <input type="text" class="form-control" id="direccion-{{ $proveedor['id'] }}" name="direccion" value="{{ $proveedor['direccion'] }}" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Actualizar Proveedor</button>
                        </form>
                    </td>
                </tr>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- Formulario para agregar un nuevo proveedor -->
    <div id="providerForm" style="display: none; justify-content: center;">
        <form action="{{ route('proveedors.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del Proveedor</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="correo">correo</label>
                <input type="text" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Proveedor</button>
        </form>
    </div>
</body>
<script>
    function toggleEditForm(providerId) {
        var form = document.getElementById('editForm-' + providerId);
        if (form.style.display === 'none') {
            form.style.display = 'table-row';
        } else {
            form.style.display = 'none';
        }
    }
</script>
@endsection
