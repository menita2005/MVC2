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
    <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Lista de Compras</h1>
<br><br>

    {{-- Mostrar lista de compras si hay --}}
    @if (!empty($compras))
    <div class="table-responsive">
            <table class="table-auto w-full mb-4">
                <thead>
                    <tr>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">ID</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Proveedor</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Producto</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Cantidad de Compra</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Valor de la Compra</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Fecha de Compra</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $compra['id'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $compra['proveedor']['nombre'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $compra['producto']['NombreP'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $compra['c_compra'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{$compra['v_compra']}}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $compra['f_compra'] }}</td>
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">
                                <a href="{{ route('compras.edit', $compra['id']) }}" class="btn btn-primary mb-1" style="background-color: #ffc600; color: #FFFFFF;">Editar</a>
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

    {{-- Formulario para crear una nueva compra --}}
    <div class="card mt-4">
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

                <div class="text-center">
                <button type="submit" class="btn btn-primary mb-4" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;">Crear Compra</button>
            </div>                </form>
        </div>
    </div>
</div>
@endsection