@extends('layouts.estilo')

@section('content')
<div class="content-wrapper d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow-sm p-5 text-center" style="max-width: 500px;">
        <h3 class="mb-4">{{ $mensaje }}</h3>
        <a href="{{ route('documento.formulario') }}" class="btn btn-secondary">Verificar otro documento</a>
    </div>
</div>
@endsection
