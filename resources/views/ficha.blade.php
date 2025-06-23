@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    @if(isset($ficha))
        {{-- Mostrar ficha y QR --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="card-title mb-4">📋 Detalles de tu Ficha</h3>
                        <i class="fas fa-id-card mb-3" style="font-size: 80px; color: #007bff;"></i>
                        <p class="text-primary font-weight-bold mb-2" style="font-size: 20px;">
                            ✅ Ficha generada correctamente
                        </p>
                        <div class="mt-4 text-left" style="font-size: 18px;">
                            <p><strong>Nombres:</strong> {{ $ficha->nombres }}</p>                            
                            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ficha->fecha)->format('d/m/Y') }}</p>
                            <p><strong>Hora:</strong> {{ $ficha->hora }}</p>
                            <p><strong>Ventanilla:</strong> {{ $ficha->ventanilla }}</p>
                            <p><strong>Código de ficha:</strong> <code>{{ $ficha->codigo }}</code></p>
                        </div>
                        <div class="mt-4">
                            <p class="mb-2" style="font-size: 16px;"><strong>Escanea este QR para ver tu ficha:</strong></p>
                            <img src="{{ $qrUrl }}" alt="QR Ficha" style="width: 150px; height: 150px;">
                            <p class="mt-2">
                                <a href="{{ $qrUrl }}" download="qr_{{ $ficha->codigo }}.png" class="btn btn-sm btn-outline-secondary mt-2">
                                    📥 Descargar QR
                                </a>
                            </p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mt-4">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Mostrar mensaje si no hay ficha --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-warning">⚠️ Aún no tienes una ficha generada</h3>
                        <p style="font-size: 18px;">
                            Por favor, genera primero una ficha para poder visualizarla aquí.
                        </p>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-warning mt-4">Volver al Panel</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
