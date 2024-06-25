@extends('layouts.app')

@section('content')
<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
    <br><br>
    <h1 class="fs-1 text-5xl font-bold text-[#ffc600] text-center mb-4">Lista de Proveedores</h1>

    @if(!empty($proveedores) && count($proveedores) > 0)
    <br><br>
    <div class="table-responsive">
        <table class="table-auto w-full mb-4">
            <thead>
                <tr>
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">ID</th>
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Nombre</th>
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Correo</th>
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Teléfono</th>
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Dirección</th>
                    @if(auth()->user()->usertype === 'admin')
                    <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                <tr>
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $proveedor['id'] }}</td>
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $proveedor['nombre'] }}</td>
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $proveedor['correo'] }}</td>
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $proveedor['telefono'] }}</td>
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $proveedor['direccion'] }}</td>
                    @if(auth()->user()->usertype === 'admin')
                    <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">
                        <form action="{{ route('proveedors.toggleStatus', $proveedor['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-1" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded" >
                                {{ $proveedor['status']? 'Desactivar' : 'Activar' }}
                            </button>
                            <br>
                        </form>

                        <!-- Botón de Editar -->
                        <button class="btn btn-primary mb-1 " onclick="toggleEditForm({{ $proveedor['id'] }})">
                            Editar
                        </button>

                        <!-- Formulario de Eliminar -->
                        <form action="{{ route('proveedors.destroy', $proveedor['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                <!-- Formulario de Edición -->
                <tr id="editForm-{{ $proveedor['id'] }}" style="display: none;">
    <td colspan="6">
        <div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
            <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Editar Proveedor</h1>
            <form action="{{ route('proveedors.update', $proveedor['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre-{{ $proveedor['id'] }}" class="text-lg font-bold">Nombre del Proveedor</label>
                    <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="nombre-{{ $proveedor['id'] }}" name="nombre" value="{{ $proveedor['nombre'] }}" required>
                </div>
                <div class="form-group">
                    <label for="correo-{{ $proveedor['id'] }}" class="text-lg font-bold">Correo</label>
                    <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="correo-{{ $proveedor['id'] }}" name="correo" value="{{ $proveedor['correo'] }}" required>
                </div>
                <div class="form-group">
                    <label for="telefono-{{ $proveedor['id'] }}" class="text-lg font-bold">Teléfono</label>
                    <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="telefono-{{ $proveedor['id'] }}" name="telefono" value="{{ $proveedor['telefono'] }}" required>
                </div>
                <div class="form-group">
                    <label for="direccion-{{ $proveedor['id'] }}" class="text-lg font-bold">Dirección</label>
                    <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="direccion-{{ $proveedor['id'] }}" name="direccion" value="{{ $proveedor['direccion'] }}" required>
                </div>
                <div class="text-center">
     <button type="submit" class="btn btn-primary mb-4" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;">Actualizar Proveedor</button>
</div>            </form>
        </div>
    </td>
</tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align: center; margin-top: 50px;">
        <h2>No hay proveedores disponibles.</h2>
    </div>
    @endif

    <!-- Botón para agregar proveedor, visible solo para admins -->
    <div class="text-center">

    @if(auth()->user()->usertype === 'admin')
    <button class="btn btn-primary mb-4" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;" onclick="document.getElementById('providerForm').style.display='flex'">
        Agregar Proveedor
    </button>
    @endif
</div>

    <!-- Formulario para agregar un nuevo proveedor -->
    <div id="providerForm" style="display: none; justify-content: center;">
    <div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
        <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Agregar Proveedor</h1>
        <form action="{{ route('proveedors.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="nombre" class="text-lg font-bold">Nombre del Proveedor</label>
                <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="correo" class="text-lg font-bold">Correo</label>
                <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="telefono" class="text-lg font-bold">Teléfono</label>
                <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion" class="text-lg font-bold">Dirección</label>
                <input type="text" class="form-control w-full p-2 pl-10 text-sm text-gray-700" id="direccion" name="direccion" required>
            </div>
            <br>
            <div class="text-center">
     <button type="submit" class="btn btn-primary mb-4" class="btn btn-primary mb-4 text-center" style="background-color: #ffc600; color: #FFFFFF;">Guardar Proveedor</button>
</div>
        </form>
    </div>
</div>

    <script>
        function toggleEditForm(providerId) {
            var form = document.getElementById('editForm-' + providerId);
            if (form.style.display === 'none') {
                form.style.display = 'table-row';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
@endsection