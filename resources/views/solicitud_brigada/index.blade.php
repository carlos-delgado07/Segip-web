@extends('layouts.estilo')

@section('content')
    <div class="content-wrapper">
        <h2>Solicitudes de Brigada de Seguridad</h2>

        <div id="map" style="height: 600px; width: 100%; margin-bottom: 20px;"></div>
    </div>

    <script>
        function initMap() {
            const center = {
                lat: -17.7833,
                lng: -63.1821
            }; // Santa Cruz centro
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: center,
            });

            const solicitudes = @json($solicitudes);
            console.log('Solicitudes:', solicitudes);
            console.log('Tipo:', Array.isArray(solicitudes));

            solicitudes.forEach(s => {
                const marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(s.latitud),
                        lng: parseFloat(s.longitud)
                    },
                    map: map,
                    title: s.titulo
                });

                const info = new google.maps.InfoWindow({
                    content: `
                        <strong>${s.titulo}</strong><br>
                        Estado: ${s.estado}<br>
                        ${s.contenido}<br>
                        <small>Registrado: ${new Date(s.created_at).toLocaleString()}</small>
                    `
                });

                marker.addListener('click', () => {
                    info.open(map, marker);
                });
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap">
    </script>
@endsection
