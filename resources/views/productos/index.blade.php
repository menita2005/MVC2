@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Mostrar mensaje si no hay productos -->
    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    <!-- Mostrar mensaje de éxito o error -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="fs-1 text-center">Lista de Productos</h1>
    <button class="btn btn-primary mb-4" onclick="toggleForm('productForm')">Agregar Producto</button>
 <div id="productForm" style="display: none;">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="NombreP">Nombre del Producto</label>
                <input type="text" class="form-control" id="NombreP" name="NombreP" required>
            </div>
            <div class="form-group">
                <label for="Descripcion">Descripción</label>
                <textarea class="form-control" id="Descripcion" name="Descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label for="Precio">Precio</label>
                <input type="number" class="form-control" id="Precio" name="Precio" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select class="form-control" id="categoria_id" name="categoria_id" required>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria['id'] }}">{{ $categoria['Nombre'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Agregar Producto</button>
        </form>
    </div>
   

    @if (!empty($productos))
     <!-- Formulario para agregar un nuevo producto -->
    
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto['id'] }}</td>
                            <td>{{ $producto['NombreP'] }}</td>
                            <td>{{ $producto['Descripcion'] }}</td>
                            <td>{{ $producto['Precio'] }}</td>
                            <td>{{ $producto['stock'] }}</td>
                            <td>{{ collect($categorias)->firstWhere('id', $producto['categoria_id'])['Nombre'] ?? 'Sin Categoría' }}</td>
                            <td>{{ collect($proveedores)->firstWhere('id', $producto['proveedor_id'])['nombre'] ?? 'Sin Proveedor' }}</td>
                            <td>
                                <!-- Botón de Editar -->
                                <button class="btn btn-primary" onclick="toggleEditForm({{ $producto['id'] }})">Editar</button>
                                <form action="{{ route('productos.destroy', $producto['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <tr id="editForm-{{ $producto['id'] }}" style="display: none;">
                            <td colspan="8">
                                <form action="{{ route('productos.update', $producto['id']) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="NombreP-{{ $producto['id'] }}">Nombre del Producto</label>
                                        <input type="text" class="form-control" id="NombreP-{{ $producto['id'] }}" name="NombreP" value="{{ $producto['NombreP'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Descripcion-{{ $producto['id'] }}">Descripción</label>
                                        <textarea class="form-control" id="Descripcion-{{ $producto['id'] }}" name="Descripcion" required>{{ $producto['Descripcion'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Precio-{{ $producto['id'] }}">Precio</label>
                                        <input type="number" class="form-control" id="Precio-{{ $producto['id'] }}" name="Precio" value="{{ $producto['Precio'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock-{{ $producto['id'] }}">Stock</label>
                                        <input type="number" class="form-control" id="stock-{{ $producto['id'] }}" name="stock" value="{{ $producto['stock'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoria_id-{{ $producto['id'] }}">Categoría</label>
                                        <select class="form-control" id="categoria_id-{{ $producto['id'] }}" name="categoria_id" required>
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria['id'] }}" {{ $producto['categoria_id'] == $categoria['id'] ? 'selected' : '' }}>{{ $categoria['Nombre'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="proveedor_id-{{ $producto['id'] }}">Proveedor</label>
                                        <select class="form-control" id="proveedor_id-{{ $producto['id'] }}" name="proveedor_id" required>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor['id'] }}" {{ $producto['proveedor_id'] == $proveedor['id'] ? 'selected' : '' }}>{{ $proveedor['nombre'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-3">Actualizar Producto</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No hay productos disponibles.</p>
    @endif
</div>

<script>
function toggleForm(formId) {
    var form = document.getElementById(formId);
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function toggleEditForm(productId) {
    var form = document.getElementById('editForm-' + productId);
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'table-row';
    } else {
        form.style.display = 'none';
    }
}
</script>
@endsection
