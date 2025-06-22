@extends('layouts.estilo')

@section('content')
<div class="container mt-4">
    <h3>Nuevo Usuario</h3>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña:</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label class="form-label">Roles:</label>
            <div class="form-check">
                @foreach ($roles as $role)
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label><br>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
