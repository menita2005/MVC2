@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-5xl font-bold text-[#ffc600] text-center mb-4">Editar Categoría</h1>
    
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

    <div class="card mt-4">
        <div class="card-header">Editar Categoría</div>
        <div class="card-body">
            <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="Nombre" class="form-label">Nombre:</label>
                    <input type="text" name="Nombre" id="Nombre" class="form-control" value="{{ $categoria->Nombre }}" required>
                    @error('Nombre')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mb-4" style="background-color: #ffc600; color: #FFFFFF;">Actualizar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
