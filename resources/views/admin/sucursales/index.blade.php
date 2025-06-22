@extends('layouts.estilo')

@section('content')
    <div class="container">
        <h2>Sucursales</h2>
        <a href="{{ route('admin.sucursales.create') }}" class="btn btn-primary mb-3">Nueva Sucursal</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Municipio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sucursales as $sucursal)
                        <tr>
                            <td>{{ $sucursal->nombre }}</td>
                            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                title="{{ $sucursal->direccion }}">
                                {{ $sucursal->direccion }}
                            </td>

                            <td>{{ $sucursal->telefono ?? '—' }}</td>
                            <td>{{ $sucursal->municipio->nombre ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.sucursales.ventanillas', $sucursal->id) }}"
                                    class="btn btn-sm btn-info">
                                    Ventanillas
                                </a>
                                <a href="{{ route('admin.sucursales.edit', $sucursal) }}"
                                    class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.sucursales.destroy', $sucursal) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta sucursal?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay sucursales registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
