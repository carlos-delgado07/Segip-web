<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VerificarCIControllerApi extends Controller
{
    public function compararImagen(Request $request)
    {
        set_time_limit(300); // ✅ Esto da 5 minutos como máximo
        // ✅ Validar ambas imágenes
        $request->validate([
            'imagen1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Validación de imagen1
            'imagen2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Validación de imagen2
        ]);

        // 📷 Obtener ambas imágenes desde la solicitud
        $imagen1 = $request->file('imagen1');
        $imagen2 = $request->file('imagen2');

        // Agregar depuración para verificar si las imágenes son nulas
        if (!$imagen1) {
            return response()->json([
                'error' => 'No se ha recibido imagen1.'
            ], 422);
        }

        if (!$imagen2) {
            return response()->json([
                'error' => 'No se ha recibido imagen2.'
            ], 422);
        }

        // 🔄 Convertir ambas imágenes a base64
        $base64Imagen1 = base64_encode(file_get_contents($imagen1->getPathName()));
        $base64Imagen2 = base64_encode(file_get_contents($imagen2->getPathName()));

        // 📨 Preparar el payload con ambas imágenes codificadas en base64
        $data = [
            'imagen1' => $base64Imagen1,
            'imagen2' => $base64Imagen2,
        ];

        // 🚀 Enviar solicitud a Flask para la verificación de imágenes
        $client = new Client();
        try {
            // Enviamos la solicitud POST a Flask
            $response = $client->post('http://localhost:5000/verificar', [
                'json' => $data // Enviamos el cuerpo en formato JSON
            ]);

            // Decodificamos la respuesta de Flask
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Retornamos la respuesta desde Flask
            return response()->json($responseData);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Captura errores 400 desde Flask (por ejemplo, si los nombres no coinciden o hay un error de validación)
            $errorBody = json_decode($e->getResponse()->getBody(), true);
            return response()->json([
                'error' => $errorBody['error'] ?? 'Error desconocido desde el servidor de verificación.'
            ], 400);
        } catch (\Exception $e) {
            // Captura errores de conexión u otros fallos graves (como el servidor Flask no disponible)
            return response()->json([
                'error' => 'No se pudo conectar al servidor de verificación.'
            ], 500);
        }
    }
}
