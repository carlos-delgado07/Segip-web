@extends('layouts.estilo')

@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Nueva Sucursal</h4>
                <form method="POST" action="{{ route('admin.sucursales.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Teléfono</label>
                                <div class="col-sm-9">
                                    <input type="text" name="telefono" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" name="direccion" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Municipio</label>
                                <div class="col-sm-9">
                                    <select name="municipio_id" class="form-control" required>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Checkbox de Servicios --}}
                    <div class="row">
                        <label class="col-sm-12 col-form-label">Servicios disponibles:</label>
                        <div class="form-group row">
                            @foreach ($servicios as $servicio)
                                <div class="col-md-4">
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="servicios[]"
                                                value="{{ $servicio->id }}">
                                            {{ $servicio->nombre }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ubicación en el mapa</label>
                                <div id="map" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Latitud</label>
                                <div class="col-sm-9">
                                    <input type="text" id="latitud" name="latitud" class="form-control" required
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Longitud</label>
                                <div class="col-sm-9">
                                    <input type="text" id="longitud" name="longitud" class="form-control" required
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Crear</button>
                    <a href="{{ route('admin.sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Google Maps --}}
    <script>
        let map;
        let marker;

        function initMap() {
            const defaultLocation = {
                lat: -17.7833,
                lng: -63.1821
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 12,
            });

            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });

            document.getElementById('latitud').value = defaultLocation.lat;
            document.getElementById('longitud').value = defaultLocation.lng;

            map.addListener("click", (e) => {
                placeMarker(e.latLng);
            });

            marker.addListener("dragend", () => {
                const position = marker.getPosition();
                document.getElementById("latitud").value = position.lat();
                document.getElementById("longitud").value = position.lng();
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
