@extends('layouts.app')

@section('content')
<body>
    <!-- Formulario para crear un nuevo producto -->
    <br><br>
    

    <h1 class="fs-1" style="text-align: center;">Lista de Productos</h1 ><button class="btn btn-primary" style="display: flex; justify-content: center;" onclick="document.getElementById('productForm').style.display='flex'">Agregar Producto</button>

    <br><br>
    <div style="display: flex; justify-content: center;">
        <table border="1" style="border-collapse: collapse; width: 80%;">
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
                     <form action="{{ route('productos.destroy', $producto['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                    </form>
                    </td>
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
            </tr>
            @endforeach
        </table>
    </div>
    <div id="productForm" style="display: none; justify-content: center;">
        <form action="{{ route('productos.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group ">
                <label for="NombreP" class="col-sm-2 col-form-label">Nombre del Producto</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="NombreP" name="NombreP" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="Descripcion" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3" required></textarea>
                </div>
            </div>
            <div class="form-group ">
                <label for="Precio" class="col-sm-2 col-form-label">Precio</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="Precio" name="Precio" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
            </div>
            <div class="form-group ">
                <label for="categoria_id" class="col-sm-2 col-form-label">Categoría</label>
                <div class="col-sm-10">
                    <select class="form-control" id="categoria_id" name="categoria_id" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria['id'] }}">{{ $categoria['Nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <label for="proveedor_id" class="col-sm-2 col-form-label">Proveedor</label>
                <div class="col-sm-10">
                    <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script>
function toggleEditForm(productId) {
    var form = document.getElementById('editForm-' + productId);
    if (form.style.display === 'none') {
        form.style.display = 'table-row';
    } else {
        form.style.display = 'none';
    }
}
</script>
@endsection
