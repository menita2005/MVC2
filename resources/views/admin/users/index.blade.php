@extends('layouts.app')

@section('content')
<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
<h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Gestionar Usuarios</h1>
    <table class="table-auto w-full mb-4">
     <thead>
    <tr>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px;">ID</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px;">Nombre</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px;">Email</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px;">Estado</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px;">Acciones</th>
    </tr>
</thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="px-4 py-2">{{ $user->id }}</td>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->status? 'Activo' : 'Inactivo' }}</td>
                <td class="px-4 py-2">
                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ $user->status? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection