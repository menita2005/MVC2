@extends('layouts.app')

@section('content')
<div class="container min-h-screen bg-blue-500">
    <h1 class="fs-1 text-center">Agregar Producto</h1>
    <br><br>

    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

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
@endsection
