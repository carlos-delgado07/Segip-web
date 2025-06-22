@extends('layouts.estilo')

@section('content')
    <div class="container">
        <h2>Usuarios</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Nuevo Usuario</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->join(', ') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar al usuario {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
