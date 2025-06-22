@extends('layouts.estilo')

@section('content')
<div class="container">
    <h2>Servicios</h2>
    <a href="{{ route('admin.servicios.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tiempo Estimado (min)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servicios as $servicio)
            <tr>
                <td>{{ $servicio->nombre }}</td>
                <td>{{ $servicio->tiempo_estimado }}</td>
                <td>
                    <a href="{{ route('admin.servicios.edit', $servicio) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('admin.servicios.destroy', $servicio) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar servicio?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center text-muted">No hay servicios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
