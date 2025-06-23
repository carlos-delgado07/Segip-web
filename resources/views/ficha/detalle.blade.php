@extends('layouts.estilo')

@section('content')
    <div class="container text-center">
        <h3>Ficha Generada</h3>
        <p><strong>Código:</strong> {{ $ficha->codigo }}</p>
        <p><strong>Fecha:</strong> {{ $ficha->fecha }}</p>
        <p><strong>Hora:</strong> {{ $ficha->hora }}</p>
        <p><strong>Sucursal:</strong> {{ optional($ficha->sucursal)->nombre ?? 'Sin asignar' }}</p>
        <p><strong>Ventanilla:</strong> {{ $ficha->ventanilla }}</p>

        <div class="mt-4">
            <img src="{{ asset('storage/qr/ficha_' . $ficha->codigo . '.png') }}" alt="QR Ficha">
        </div>
    </div>
@endsection
