@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title mb-4 text-warning">⚠️ Ya tienes una ficha generada para mañana</h3>

                    {{-- Ícono de advertencia --}}
                    <i class="fas fa-exclamation-triangle text-warning mb-4" style="font-size: 80px;"></i>

                    <p class="mb-4" style="font-size: 18px;">
                        Recuerda que solo puedes generar <strong>una ficha por día</strong>.
                    </p>

                    <div class="mt-4 text-left" style="font-size: 18px;">
                        <p><strong>Nombres:</strong> {{ $fichaExistente->nombres }}</p>
                        <p><strong>Apellidos:</strong> {{ $fichaExistente->apellidos }}</p>
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fichaExistente->fecha)->format('d/m/Y') }}</p>
                        <p><strong>Hora:</strong> {{ $fichaExistente->hora }}</p>
                        <p><strong>Ventanilla asignada:</strong> {{ $fichaExistente->ventanilla }}</p>
                        <p><strong>Código de ficha:</strong> <code>{{ $fichaExistente->codigo }}</code></p>
                    </div>

                    {{-- QR de la ficha existente --}}
                    <div class="mt-4">
                        <p class="mb-2" style="font-size: 16px;"><strong>Escanea este QR para ver tu ficha:</strong></p>
                        
                        {{-- Mostrando el QR --}}
                        <img src="{{ $qrUrl }}" alt="QR Ficha Existente" style="width: 150px; height: 150px;">

                        <p class="mt-2">
                            {{-- Botón para descargar el QR --}}
                            <a href="{{ $qrUrl }}" download="qr_{{ $fichaExistente->codigo }}.png" class="btn btn-sm btn-outline-secondary mt-2">
                                📥 Descargar QR
                            </a>
                        </p>
                    </div>

                    {{-- Botón para volver al panel --}}
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary mt-4">Volver al panel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
