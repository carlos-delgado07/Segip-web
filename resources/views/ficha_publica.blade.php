<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha - {{ $ficha->codigo }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Roboto', sans-serif;
        }
        .ficha-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .titulo {
            font-size: 22px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }
        .dato {
            font-size: 18px;
            margin: 10px 0;
        }
        .codigo {
            font-size: 24px;
            font-weight: bold;
            background: #f1f1f1;
            padding: 10px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 15px;
            letter-spacing: 2px;
        }
        .qr-container {
            margin-top: 30px;
        }
        .qr-container img {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .boton {
            margin-top: 30px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        @media print {
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="ficha-container">
        <div class="titulo">🧾 SEGIP: Ficha de atención</div>

        {{-- Nombres y Apellidos --}}
        <div class="dato"><strong>Nombre:</strong> {{ $ficha->nombres }}</div>
        <div class="dato"><strong>Apellido:</strong> {{ $ficha->apellidos }}</div>

        {{-- Información de la ficha --}}
        <div class="dato"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ficha->fecha)->format('d/m/Y') }}</div>
        <div class="dato"><strong>Hora:</strong> {{ $ficha->hora }}</div>
        <div class="dato"><strong>Ventanilla:</strong> {{ $ficha->ventanilla }}</div>
        <div class="dato"><strong>Sucursal:</strong> {{ $ficha->sucursal->nombre }}</div>

        
        {{-- Código de la ficha --}}
        <div class="dato"><strong>Código:</strong></div>
        <div class="codigo">{{ $ficha->codigo }}</div>

        {{-- Sección para mostrar el QR --}}
        <div class="qr-container">
            <p><strong>Escanea este QR para ver tu ficha:</strong></p>
            <img src="{{ $qrUrl }}" alt="QR Ficha Pública">
        </div>

        {{-- Botón para imprimir o guardar como PDF --}}
        <div class="boton">
            <button class="btn" onclick="window.print()">🖨️ Imprimir / Guardar PDF</button>
        </div>
    </div>
</body>
</html>
