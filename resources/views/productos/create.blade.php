@extends('layouts.app')

@section('content')
<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
    <br><br>
    <h1 class="fs-1 text-5xl font-bold text-[#ffc600] text-center mb-4">Agregar Producto</h1>

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

    <form action="{{ route('productos.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="NombreP" class="text-lg font-bold">Nombre del Producto</label>
            <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="NombreP" name="NombreP" required>
        </div>
        <div class="form-group">
            <label for="Descripcion" class="text-lg font-bold">Descripción</label>
            <textarea class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="Descripcion" name="Descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="Precio" class="text-lg font-bold">Precio</label>
            <input type="number" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="Precio" name="Precio" required>
        </div>
        <div class="form-group">
            <label for="stock" class="text-lg font-bold">Stock</label>
            <input type="number" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="stock" name="stock" required>
        </div>
        <div class="form-group">
            <label for="categoria_id" class="text-lg font-bold">Categoría</label>
            <select class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="categoria_id" name="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria['id'] }}">{{ $categoria['Nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="proveedor_id" class="text-lg font-bold">Proveedor</label>
            <select class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="proveedor_id" name="proveedor_id" required>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mb-4" style="background-color: #ffc600; color: #FFFFFF;">Agregar Producto</button>
        </div>
    </form>
</div>
@endsection