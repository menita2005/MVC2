@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Formulario para crear una nueva venta -->
    <br><br>
    
    <h1 class="fs-1" style="text-align: center;">Lista de Ventas</h1>

    <!-- Botón para agregar venta, visible solo para usuarios autenticados -->
    @if(auth()->check())
    <button class="btn btn-primary mb-4" style="display: flex; justify-content: center;" onclick="document.getElementById('ventaForm').style.display='flex'">Agregar Venta</button>
    @endif
    
    <br><br>
    <!-- Formulario para agregar una nueva venta -->
    <div class="card">
        <div id="ventaForm" style="display: none; justify-content: center;">
            <div class="card-body">
            <form action="{{ route('ventas.store') }}" method="POST" class="mt-4">
                @csrf
                <div id="productos">
                    <div class="form-group">
                        <label for="producto_id">Producto</label>
                        <select class="form-control" id="producto_id" name="productos[0][producto_id]" required>
                            @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->NombreP }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="productos[0][cantidad]" required>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-success mb-2" onclick="agregarProducto()">Agregar Producto</button>
                <button type="submit" class="btn btn-success mb-2 ">Guardar Venta</button>
            </form>
        </div>
    </div>
    </div>
    <br><br>
    <div style="display: flex; justify-content: center;">
        <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Valor Venta</th>
                    @if(auth()->check())
                    @if(auth()->user()->usertype === 'admin')
                    <th>Acciones</th>
                    @endif
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->producto->NombreP }}</td>
                    <td>{{ $venta->c_compra }}</td>
                    <td>{{ $venta->v_venta }}</td>
                    @if(auth()->check())
                    
                        @if(auth()->user()->usertype === 'admin')
                        <td>
                        <!-- Formulario de Eliminar -->
                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?')">Eliminar</button>
                        </form>
                    </td>
                    
                    @endif
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    

<script>
    let contadorProductos = 1;

    function agregarProducto() {
        contadorProductos++;

        const productosDiv = document.getElementById('productos');

        const productoHtml = `
        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select class="form-control" id="producto_id" name="productos[${contadorProductos - 1}][producto_id]" required>
                @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->NombreP }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="productos[${contadorProductos - 1}][cantidad]" required>
        </div>
        `;

        const productoElement = document.createElement('div');
        productoElement.innerHTML = productoHtml;

        productosDiv.appendChild(productoElement);
    }
</script>
@endsection
