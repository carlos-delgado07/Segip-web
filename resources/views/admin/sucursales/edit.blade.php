@extends('layouts.estilo')

@section('content')
<div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Editar Sucursal</h4>
      <form class="form-sample" method="POST" action="{{ route('admin.sucursales.update', $sucursal) }}">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nombre</label>
              <div class="col-sm-9">
                <input type="text" name="nombre" class="form-control" value="{{ $sucursal->nombre }}" required>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Dirección</label>
              <div class="col-sm-9">
                <input type="text" name="direccion" class="form-control" value="{{ $sucursal->direccion }}" required>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Teléfono</label>
              <div class="col-sm-9">
                <input type="text" name="telefono" class="form-control" value="{{ $sucursal->telefono }}">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Municipio</label>
              <div class="col-sm-9">
                <select name="municipio_id" class="form-control" required>
                  @foreach ($municipios as $municipio)
                    <option value="{{ $municipio->id }}" {{ $municipio->id == $sucursal->municipio_id ? 'selected' : '' }}>
                      {{ $municipio->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- Checkbox de Servicios --}}
        <div class="row mt-3">
          <label class="col-sm-12 col-form-label">Servicios disponibles:</label>
          <div class="form-group row">
            @foreach ($servicios as $servicio)
              <div class="col-md-4">
                <div class="form-check form-check-success">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="servicios[]" value="{{ $servicio->id }}"
                      {{ $sucursal->servicios->contains($servicio->id) ? 'checked' : '' }}>
                    {{ $servicio->nombre }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <p class="card-description mt-4">Ubicación en el mapa</p>
        <div class="form-group">
          <div id="map" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Latitud</label>
              <div class="col-sm-9">
                <input type="text" id="latitud" name="latitud" class="form-control" value="{{ $sucursal->latitud }}" required readonly>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Longitud</label>
              <div class="col-sm-9">
                <input type="text" id="longitud" name="longitud" class="form-control" value="{{ $sucursal->longitud }}" required readonly>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-success me-2">Actualizar</button>
        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </div>
</div>

<script>
  let map;
  let marker;

  function initMap() {
    const initialPosition = {
      lat: parseFloat({{ $sucursal->latitud ?? -17.7833 }}),
      lng: parseFloat({{ $sucursal->longitud ?? -63.1821 }})
    };

    map = new google.maps.Map(document.getElementById("map"), {
      center: initialPosition,
      zoom: 12,
    });

    marker = new google.maps.Marker({
      position: initialPosition,
      map: map,
      draggable: true
    });

    map.addListener("click", (e) => placeMarker(e.latLng));

    marker.addListener("dragend", () => {
      const pos = marker.getPosition();
      document.getElementById("latitud").value = pos.lat();
      document.getElementById("longitud").value = pos.lng();
    });
  }

  function placeMarker(location) {
    marker.setPosition(location);
    document.getElementById("latitud").value = location.lat();
    document.getElementById("longitud").value = location.lng();
  }
</script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap">
</script>
@endsection
