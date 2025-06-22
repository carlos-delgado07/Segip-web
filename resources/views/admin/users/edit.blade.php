@extends('layouts.estilo')

@section('content')
<div class="container mt-4">
    <h3>Editar Usuario</h3>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña (opcional):</label>
            <input type="password" name="password" class="form-control" minlength="6">
        </div>

        <div class="mb-3">
            <label class="form-label">Roles:</label>
            <div class="form-check">
                @foreach ($roles as $role)
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                        id="role_{{ $role->id }}"
                        {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label><br>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
