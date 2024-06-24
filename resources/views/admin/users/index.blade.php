@extends('layouts.app')

@section('content')
<div class="container">
@include('layouts.navigationadmin')

    <br><br>
    <h1 class="fs-1" style="text-align: center;">Gestionar Usuarios</h1>
    <br><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ $user->status ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
