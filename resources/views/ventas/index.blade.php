    @extends('layouts.app')

    @section('content')
    <div class="container">
        <br><br>
        <h1  class="fs-1 text-center">Listado de Ventas</h1>

        <!-- Mostrar mensajes de éxito o error -->
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
        <div class="card">
        <h2 class="card-header">Crear Nueva Venta</h2>
        <div class="card-body">
        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select class="form-control" id="producto_id" name="producto_id" required>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto['id'] }}">{{ $producto['NombreP'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="c_compra">Cantidad</label>
                <input type="number" class="form-control" id="c_compra" name="c_compra" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Crear Venta</button>
        </form>
        </div>
        </div>
        <br><br>
        <!-- Tabla de Ventas -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Venta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Valor Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta['id'] }}</td>
                        <td>{{ $venta['f_venta'] }}</td>
                        <td>{{ $venta['producto']['NombreP'] }}</td>
                        <td>{{ $venta['c_compra'] }}</td>
                        <td>{{ $venta['v_venta'] }}</td>
                        <td>
                            <!-- Botón para eliminar la venta -->
                            <form action="{{ route('ventas.destroy', $venta['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Formulario para crear una nueva venta -->
        
    </div>
    @endsection
