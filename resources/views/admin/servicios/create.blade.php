@extends('layouts.estilo')

@section('content')
<div class="container mt-4">
    <h3>Nuevo Servicio</h3>
    <form method="POST" action="{{ route('admin.servicios.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tiempo Estimado (minutos):</label>
            <input type="number" name="tiempo_estimado" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
