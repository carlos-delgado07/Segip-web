@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title mb-4">📋 Detalles de tu Ficha</h3>

                    {{-- Icono de cédula de identidad --}}
                    <i class="fas fa-id-card mb-3" style="font-size: 80px; color: #007bff;"></i>

                    <p class="text-primary font-weight-bold mb-2" style="font-size: 20px;">
                        ✅ Ficha generada correctamente
                    </p>

                    <div class="mt-4 text-left" style="font-size: 18px;">
                        <p><strong>Nombres:</strong> {{ $ficha->nombres }}</p>
                        <p><strong>Apellidos:</strong> {{ $ficha->apellidos }}</p>
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ficha->fecha)->format('d/m/Y') }}</p>
                        <p><strong>Hora:</strong> {{ $ficha->hora }}</p>
                        <p><strong>Ventanilla:</strong> {{ $ficha->ventanilla }}</p>
                        <p><strong>Código de ficha:</strong> <code>{{ $ficha->codigo }}</code></p>
                    </div>

                    {{-- QR de la ficha --}}
                    <div class="mt-4">
                        <p class="mb-2" style="font-size: 16px;"><strong>Escanea este QR para ver tu ficha:</strong></p>
                        
                        {{-- Mostrando el QR --}}
                        <img src="{{ $qrUrl }}" alt="QR Ficha" style="width: 150px; height: 150px;">

                        <p class="mt-2">
                            {{-- Botón para descargar el QR --}}
                            <a href="{{ $qrUrl }}" download="qr_{{ $ficha->codigo }}.png" class="btn btn-sm btn-outline-secondary mt-2">
                                📥 Descargar QR
                            </a>
                        </p>
                    </div>

                    {{-- Botón para volver al panel --}}
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mt-4">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
