@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Add this line to link the CSS file -->

<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
    <!-- Mostrar mensajes de sesión -->
    @if (session('message'))
        <div class="alert alert-info mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <br><br>
    <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Lista de Productos</h1>
    <br><br>

    @if (!empty($productos))
        <div class="table-responsive">
            <table class="table  w-full mb-4">
                <thead>
                    <tr>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">ID</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Nombre</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Descripción</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Precio</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Stock</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Categoría</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Proveedor</th>
                        @if(auth()->user()->usertype === 'admin')
                            <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $producto['id'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $producto['NombreP'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $producto['Descripcion'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $producto['Precio'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $producto['stock'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ collect($categorias)->firstWhere('id', $producto['categoria_id'])['Nombre']?? 'Sin Categoría' }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ collect($proveedores)->firstWhere('id', $producto['proveedor_id'])['nombre']?? 'Sin Proveedor' }}</td>
                            @if(auth()->user()->usertype === 'admin')
                                <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">
                                    <!-- Botón de Editar -->
                                    <button class="btn btn-primary mb-1" onclick="toggleEditForm({{ $producto['id'] }})">Editar</button>
                                    <form action="{{ route('productos.destroy', $producto['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mb-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @if(auth()->user()->usertype === 'admin')
                        <tr id="editForm-{{ $producto['id'] }}" style="display: none;">
    <td colspan="8">
        <div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
            <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Editar Producto</h1>
            <form action="{{ route('productos.update', $producto['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="NombreP-{{ $producto['id'] }}" class="text-lg font-bold">Nombre del Producto</label>
                    <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="NombreP-{{ $producto['id'] }}" name="NombreP" value="{{ $producto['NombreP'] }}" required>
                </div>
                <div class="form-group">
                    <label for="Descripcion-{{ $producto['id'] }}" class="text-lg font-bold">Descripción</label>
                    <textarea class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="Descripcion-{{ $producto['id'] }}" name="Descripcion" required>{{ $producto['Descripcion'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="Precio-{{ $producto['id'] }}" class="text-lg font-bold">Precio</label>
                    <input type="number" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="Precio-{{ $producto['id'] }}" name="Precio" value="{{ $producto['Precio'] }}" required>
                </div>
                <div class="form-group">
                    <label for="stock-{{ $producto['id'] }}" class="text-lg font-bold">Stock</label>
                    <input type="number" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="stock-{{ $producto['id'] }}" name="stock" value="{{ $producto['stock'] }}" required>
                </div>
                <div class="form-group">
                    <label for="categoria_id-{{ $producto['id'] }}" class="text-lg font-bold">Categoría</label>
                    <select class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="categoria_id-{{ $producto['id'] }}" name="categoria_id" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria['id'] }}" {{ $producto['categoria_id'] == $categoria['id']? 'selected' : '' }}>{{ $categoria['Nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="proveedor_id-{{ $producto['id'] }}" class="text-lg font-bold">Proveedor</label>
                    <select class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="proveedor_id-{{ $producto['id'] }}" name="proveedor_id" required>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor['id'] }}" {{ $producto['proveedor_id'] == $proveedor['id']? 'selected' : '' }}>{{ $proveedor['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;">Actualizar Producto</button>
</div>
            </form>
        </div>
    </td>
</tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center">No hay productos disponibles.</p>
    @endif

    <!-- Mostrar botón de agregar producto solo para administradores -->
    @if(auth()->user()->usertype === 'admin')
        @if(!empty($categorias) &&!empty($proveedores))
        <div class="text-center">
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;">Agregar Producto</a>
</div>  
      @else
            <p class="alert alert-warning mb-4">No hay categorías o proveedores disponibles para agregar un producto.</p>
        @endif
    @endif
</div>

<script>
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