@extends('layouts.app')

@section('content')
<div class="container">
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
<br><br>
    <h1 class="fs-1 text-center">Lista de Compras</h1>
<br><br>

    {{-- Formulario para crear una nueva compra --}}
    <div class="card">
        <div class="card-header">Crear Nueva Compra</div>
        <div class="card-body">
            <form action="{{ route('compras.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="proveedor_id" class="form-label">Proveedor:</label>
                    <select name="proveedor_id" id="proveedor_id" class="form-select">
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                        @endforeach
                    </select>
                    @error('proveedor_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto:</label>
                    <select name="producto_id" id="producto_id" class="form-select">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto['id'] }}">{{ $producto['NombreP'] }}</option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="c_compra" class="form-label">Cantidad de Compra:</label>
                    <input type="text" name="c_compra" id="c_compra" class="form-control" value="{{ old('c_compra') }}">
                    @error('c_compra')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                

                <button type="submit" class="btn btn-primary">Crear Compra</button>
            </form>
        </div>
    </div>

    {{-- Mostrar lista de compras si hay --}}
    @if (!empty($compras))
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Producto</th>
                        <th>Cantidad de Compra</th>
                        <th>Fecha de Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr>
                            <td>{{ $compra['id'] }}</td>
                            <td>{{ $compra['proveedor']['nombre'] }}</td>
                            <td>{{ $compra['producto']['NombreP'] }}</td>
                            <td>{{ $compra['c_compra'] }}</td>
                            <td>{{ $compra['f_compra'] }}</td>
                            <td>
                                <a href="{{ route('compras.edit', $compra['id']) }}" class="btn btn-primary">Editar</a>
                                <form action="{{ route('compras.destroy', $compra['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta compra?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            <p>No hay compras registradas.</p>
        </div>
    @endif
</div>
@endsection
