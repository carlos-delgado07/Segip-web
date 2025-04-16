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
                            <label for="imagen1">Sube la imagen o usa la cámara:</label>
                            <input type="file" name="imagen1" id="imagen1" accept="image/*" class="form-control-file" onchange="previewImage(event, 'preview1')" style="display: none;">
                            <button type="button" id="uploadBtn1" class="btn btn-info btn-sm mt-2">Subir Imagen</button>
                            <video id="video1" autoplay class="mt-3 w-100" style="display:none; height:200px; border:1px solid #ccc; border-radius:6px;"></video>
                            <button type="button" id="captureBtn1" class="btn btn-secondary btn-sm mt-2" style="display:none;">Capturar Foto</button>
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
                            <label for="imagen2">Sube la imagen o usa la cámara:</label>
                            <input type="file" name="imagen2" id="imagen2" accept="image/*" class="form-control-file" onchange="previewImage(event, 'preview2')" style="display: none;">
                            <button type="button" id="uploadBtn2" class="btn btn-info btn-sm mt-2">Subir Imagen</button>
                            <video id="video2" autoplay class="mt-3 w-100" style="display:none; height:200px; border:1px solid #ccc; border-radius:6px;"></video>
                            <button type="button" id="captureBtn2" class="btn btn-secondary btn-sm mt-2" style="display:none;">Capturar Foto</button>
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
    // Abrir input file
    document.getElementById('uploadBtn1').addEventListener('click', () => document.getElementById('imagen1').click());
    document.getElementById('uploadBtn2').addEventListener('click', () => document.getElementById('imagen2').click());

    // Preview imagen cargada
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = e => document.getElementById(previewId).src = e.target.result;
        reader.readAsDataURL(file);

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        const targetInput = (previewId === 'preview1') ? 'formInput1' : 'formInput2';
        document.getElementById(targetInput).files = dataTransfer.files;
    }

    // Cámara
    function iniciarCamara(videoId, tipo) {
        const video = document.getElementById(videoId);
        navigator.mediaDevices.getUserMedia({ video: { facingMode: tipo } })
            .then(stream => {
                video.srcObject = stream;
                video.style.display = 'block';
            })
            .catch(err => console.error("No se pudo acceder a la cámara", err));
    }

    function capturarImagen(videoId, formInputId, previewId) {
        const video = document.getElementById(videoId);
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById(previewId).src = dataUrl;

        const file = dataURLtoFile(dataUrl, 'captura.png');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById(formInputId).files = dataTransfer.files;
    }

    function dataURLtoFile(dataurl, filename) {
        const arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]), u8arr = new Uint8Array(bstr.length);
        for (let i = 0; i < bstr.length; i++) u8arr[i] = bstr.charCodeAt(i);
        return new File([u8arr], filename, { type: mime });
    }

    // Activar cámaras
    iniciarCamara('video1', 'environment');
    document.getElementById('captureBtn1').style.display = 'inline-block';

    iniciarCamara('video2', 'user');
    document.getElementById('captureBtn2').style.display = 'inline-block';

    // Botones capturar
    document.getElementById('captureBtn1').addEventListener('click', () => capturarImagen('video1', 'formInput1', 'preview1'));
    document.getElementById('captureBtn2').addEventListener('click', () => capturarImagen('video2', 'formInput2', 'preview2'));
</script>
@endsection
