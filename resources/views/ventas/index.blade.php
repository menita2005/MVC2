@extends('layouts.app')

@section('content')
<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
    <!-- Formulario para crear una nueva venta -->
    <br><br>
    
    <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Lista de Ventas</h1>

    <div style="display: flex; justify-content: center;">
        <div class="table-responsive">
            <table class="table-auto w-full mb-4">
                <thead>
                    <tr>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">ID</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Producto</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Cantidad</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Valor Venta</th>
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Fecha Venta</th>
                        @if(auth()->check())
                        @if(auth()->user()->usertype === 'admin')
                        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Acciones</th>
                        @endif
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                    <tr>
                        <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $venta->id }}</td>
                        <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $venta->producto->NombreP }}</td>
                        <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $venta->c_compra }}</td>
                        <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $venta->v_venta }}</td>
                        <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $venta->f_venta }}</td>
                        @if(auth()->check())
                        
                            @if(auth()->user()->usertype === 'admin')
                            <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">
                            <!-- Formulario de Eliminar -->
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-full p-2 pl-10 text-sm text-white bg-[#ff0000] hover:bg-[#ff3737]" onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?')">Eliminar</button>
                            </form>
                        </td>
                        
                        @endif
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
    <!-- Botón para agregar venta, visible solo para usuarios autenticados -->
    @if(auth()->check())
    <div class="text-center">
        <button class="btn btn-primary mb-4" style="background-color: #ffc600; color: #FFFFFF;" onclick="document.getElementById('ventaForm').style.display='flex'">Agregar Venta</button>
    </div>
    @endif
    
    <!-- Formulario para agregar una nueva venta -->
    <div class="card shadow-md">
        <div id="ventaForm" style="display: none; justify-content: center;">
            <div class="card-body p-4 pt-6 md:p-6 lg:p-12">
            <form action="{{ route('ventas.store') }}" method="POST" class="mt-4">
                @csrf
                <div id="productos">
                    <div class="form-group mb-4">
                        <label for="producto_id" class="text-lg font-bold block mb-2">Producto</label>
                        <select class="form-select w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md" id="producto_id" name="productos[0][producto_id]" required>
                            @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->NombreP }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="cantidad" class="text-lg font-bold block mb-2">Cantidad</label>
                        <input type="number" class="form-control w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md" id="cantidad" name="productos[0][cantidad]" required>
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <button type="button" class="btn btn-primary mb-4" style="background-color: #ffc600; color: #FFFFFF;" onclick="agregarProducto()">Agregar Producto</button>
                    <button type="submit" class="btn btn-primary mb-4" style="background-color: #ffc600; color: #FFFFFF;">Guardar Venta</button>
                </div>            
            </form>
        </div>
    </div>
    </div>

<script>
    let contadorProductos = 1;

    function agregarProducto() {
        contadorProductos++;

        const productosDiv = document.getElementById('productos');

        const productoHtml = `
<div class="form-group mb-4">
            <label for="producto_id" class="text-lg font-bold block mb-2">Producto</label>
            <select class="form-select w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md" id="producto_id" name="productos[${contadorProductos - 1}][producto_id]" required>
                @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->NombreP }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-4">
            <label for="cantidad" class="text-lg font-bold block mb-2">Cantidad</label>
            <input type="number" class="form-control w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md" id="cantidad" name="productos[${contadorProductos - 1}][cantidad]" required>
        </div>
        `;

        const productoElement = document.createElement('div');
        productoElement.innerHTML = productoHtml;

        productosDiv.appendChild(productoElement);
    }
</script>
@endsection