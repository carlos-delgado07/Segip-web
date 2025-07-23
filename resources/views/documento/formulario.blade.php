@extends('layouts.estilo')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">

        <!-- Card: Documento Judicial -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-primary mb-4">Subir Documento Judicial</h4>
                    <form action="{{ route('documento.verificar') }}" method="POST" enctype="multipart/form-data" id="formulario-verificacion">
                        @csrf
                        
                        <div class="form-group">
                            <label for="imagen">Selecciona la imagen del documento judicial</label>
                            <input 
                                type="file" 
                                name="imagen" 
                                id="imagen" 
                                accept="image/*" 
                                class="form-control-file @error('imagen') is-invalid @enderror" 
                                onchange="previewImage(event, 'preview')"
                                required
                            >
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img 
                                id="preview" 
                                class="mt-3 img-fluid rounded border" 
                                style="max-height: 300px;" 
                                src="" 
                                alt="Vista previa del documento judicial"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Verificar Documento</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Scripts --}}
<script>
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
</script>
@endsection
