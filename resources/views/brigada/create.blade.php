@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <!-- Tarjeta de Solicitud -->
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Solicitar Brigada Móvil</h4>

                    {{-- Mensajes de éxito o error --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('brigada.store') }}" id="brigadaForm">
                        @csrf

                        <div class="form-group">
                            <label for="titulo">Título de la solicitud</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required maxlength="255" value="{{ old('titulo') }}">
                        </div>

                        <div class="form-group">
                            <label for="contenido">Descripción (opcional)</label>
                            <textarea name="contenido" id="contenido" class="form-control" rows="3">{{ old('contenido') }}</textarea>
                        </div>

                        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
                        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">

                        <div class="form-group">
                            <button type="button" class="btn btn-info" onclick="obtenerUbicacion()">
                                📍 Obtener mi ubicación actual
                            </button>
                            <div id="ubicacionInfo" class="mt-2 text-muted"></div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block mt-3" id="submitBtn" disabled>
                            🚑 Solicitar Brigada
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS de geolocalización --}}
<script>
    function obtenerUbicacion() {
        if (!navigator.geolocation) {
            alert('La geolocalización no es soportada por este navegador.');
            return;
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitud').value = position.coords.latitude;
            document.getElementById('longitud').value = position.coords.longitude;

            document.getElementById('ubicacionInfo').innerText =
                `Ubicación detectada: Latitud ${position.coords.latitude.toFixed(6)}, Longitud ${position.coords.longitude.toFixed(6)}`;

            document.getElementById('submitBtn').disabled = false;
        }, function(error) {
            alert('No se pudo obtener su ubicación: ' + error.message);
        });
    }
</script>
@endsection
