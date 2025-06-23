@extends('layouts.estilo')

@section('content')
    <div class="container">
        <h3>Solicitar Ficha con Depósito</h3>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('ficha.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="servicio_id">Tipo de Trámite</label>
                <select name="servicio_id" class="form-control" required>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="sucursal_id">Sucursal</label>
                <select name="sucursal_id" class="form-control" required>
                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="deposito">Imagen del Depósito</label>
                <input type="file" name="deposito" id="depositoInput" class="form-control" accept="image/*" required>
            </div>

            <div id="previewContainer" class="mt-3" style="display:none;">
                <p><strong>Vista previa:</strong></p>
                <img id="previewImage" src="" style="max-width: 300px; border: 1px solid #ccc; padding: 5px;">
            </div>


            <button type="submit" class="btn btn-success mt-3">Solicitar Ficha</button>
        </form>
    </div>

    <script>
        document.getElementById('depositoInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                previewImage.src = '';
                previewContainer.style.display = 'none';
            }
        });
    </script>
@endsection
