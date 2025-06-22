@extends('layouts.estilo')

@section('content')
<div class="container mt-4">
    <h3>Editar Servicio</h3>
    <form method="POST" action="{{ route('admin.servicios.update', $servicio) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $servicio->nombre }}" readonly>
        </div>

        <div class="mb-3">
            <label>Tiempo Estimado (minutos):</label>
            <input type="number" name="tiempo_estimado" class="form-control" value="{{ $servicio->tiempo_estimado }}" required min="1">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
