@extends('layouts.app')

@section('content')
<div class="container min-h-screen bg-500">

    <!-- Mensajes de notificación -->
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
    <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Editar Compra</h1>
    <br><br>

    <div class="card mt-4">
        <div class="card-header text-2xl font-semibold">Editar Compra</div>
        <div class="card-body">
            <form action="{{ route('compras.update', $compra['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="proveedor_id" class="form-label">Proveedor:</label>
                    <select name="proveedor_id" id="proveedor_id" class="form-select">
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor['id'] }}" {{ $compra->proveedor_id == $proveedor['id'] ? 'selected' : '' }}>
                                {{ $proveedor['nombre'] }}
                            </option>
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
                            <option value="{{ $producto['id'] }}" {{ $compra->producto_id == $producto['id'] ? 'selected' : '' }}>
                                {{ $producto['NombreP'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="c_compra" class="form-label">Cantidad de Compra:</label>
                    <input type="number" name="c_compra" id="c_compra" class="form-control" value="{{ $compra->c_compra }}" min="1" required>
                    @error('c_compra')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mb-4" style="background-color: #ffc600; color: #FFFFFF;">Actualizar Compra</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
