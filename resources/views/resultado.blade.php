@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title mb-4">Resultado de la Comparación</h3>

                    @if (isset($response['mensaje']) && isset($response['usuario']))
                        {{-- Check animado --}}
                        <svg class="checkmark mb-3" viewBox="0 0 52 52" style="width: 80px; height: 80px;">
                            <circle cx="26" cy="26" r="24" stroke="#4caf50" stroke-width="6" fill="none" style="stroke-dasharray: 240; stroke-dashoffset: 0; animation: draw-circle 1s ease forwards;"></circle>
                            <path d="M14 27 l10 10 l15 -15" stroke="#4caf50" stroke-width="6" fill="none" style="stroke-dasharray: 50; stroke-dashoffset: 0; animation: draw-check 0.5s ease 1s forwards;"></path>
                        </svg>

                        <p class="verificado-text text-success font-weight-bold" style="font-size: 20px;">✅ Verificado exitosamente</p>

                        <h5 class="mt-4">Usuario encontrado:</h5>
                        <p><strong>Nombre:</strong> {{ $response['usuario']['nombre'] }} {{ $response['usuario']['apellido'] }}</p>
                        <p><strong>Email:</strong> {{ $response['usuario']['email'] }}</p>

                    @else
                        <p class="text-danger mt-4"><strong>Error:</strong> {{ $response['error'] ?? 'Algo salió mal' }}</p>
                    @endif

                    <a href="{{ route('imagen.form') }}" class="btn btn-primary mt-4">Volver a intentarlo</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Animaciones con estilos inline para evitar conflicto --}}
<style>
    @keyframes draw-circle {
        0% { stroke-dashoffset: 240; }
        100% { stroke-dashoffset: 0; }
    }

    @keyframes draw-check {
        0% { stroke-dashoffset: 50; }
        100% { stroke-dashoffset: 0; }
    }

    .verificado-text {
        opacity: 0;
        animation: fade-in 1s ease 1.5s forwards;
    }

    @keyframes fade-in {
        to {
            opacity: 1;
        }
    }
</style>
@endsection
