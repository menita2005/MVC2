@extends('layouts.app')

@section('content')
<div class="w-full p-4 pt-6 md:p-6 lg:p-12 bg-white rounded shadow-md">
<h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Gestionar Usuarios</h1>
<div class="table-responsive">
    <table class="table-auto w-full mb-4">
     <thead>
    <tr>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">ID</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Nombre</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Email</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Estado</th>
        <th style="background-color: #efb810; color: #FFFFFF; padding: 10px; text-align: center;">Acciones</th>
    </tr>
</thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="px-4 py-2" style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $user->id }}</td>
                <td class="px-4 py-2"  style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $user->name }}</td>
                <td class="px-4 py-2"  style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $user->email }}</td>
                <td class="px-4 py-2"  style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">{{ $user->status? 'Activo' : 'Inactivo' }}</td>
                <td class="px-4 py-2"  style="background-color: #efb71045; color: #000; padding: 10px; text-align: center;">
                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary mb-1" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded" >
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