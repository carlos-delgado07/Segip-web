@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <!-- Card 1: Carnet -->
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Foto del Carnet</h4>
                    <form class="forms-sample">
                        <div class="form-group">
                            <label for="imagen1">Sube la imagen:</label>
                            <input type="file" name="imagen1" id="imagen1" accept="image/*" class="form-control-file" onchange="previewImage(event, 'preview1'); updateFormInput('formInput1', event.target.files[0]);">
                            <img id="preview1" class="mt-3 img-fluid rounded" src="" alt="Vista previa del carnet">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card 2: Recibo -->
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recibo de Pago</h4>
                    <form class="forms-sample">
                        <div class="form-group">
                            <label for="imagen2">Sube la imagen:</label>
                            <input type="file" name="imagen2" id="imagen2" accept="image/*" class="form-control-file" onchange="previewImage(event, 'preview2'); updateFormInput('formInput2', event.target.files[0]);">
                            <img id="preview2" class="mt-3 img-fluid rounded" src="" alt="Vista previa del recibo">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón debajo de las dos tarjetas -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-4 text-center">
            <form action="{{ route('imagen.comparar') }}" method="POST" enctype="multipart/form-data" id="formulario-verificacion">
                @csrf
                <input type="file" name="imagen1" id="formInput1" style="display:none;" />
                <input type="file" name="imagen2" id="formInput2" style="display:none;" />
                <button type="submit" class="btn btn-primary btn-lg btn-block">Verificar</button>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    // Mostrar vista previa
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Actualizar inputs ocultos del formulario
    function updateFormInput(inputId, file) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById(inputId).files = dataTransfer.files;
    }
</script>
@endsection
