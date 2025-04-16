<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VerificarCIController extends Controller
{
    public function compararImagen(Request $request)
    {
        // Validación de las imágenes
        $request->validate([
            'imagen1' => 'required|image|mimes:jpeg,png,jpg|max:2048',  // Máximo tamaño 2MB
            'imagen2' => 'required|image|mimes:jpeg,png,jpg|max:2048',  // Máximo tamaño 2MB
        ]);
    
        try {
            // Convertir las imágenes a Base64
            $base64Imagen1 = base64_encode(file_get_contents($request->file('imagen1')->getPathName()));
            $base64Imagen2 = base64_encode(file_get_contents($request->file('imagen2')->getPathName()));
    
            // Preparar los datos para enviar al servidor Flask
            $data = [
                'imagen1' => $base64Imagen1,
                'imagen2' => $base64Imagen2,
            ];
    
            // Crear una instancia de GuzzleHttp\Client
            $client = new Client();
            // Enviar la solicitud POST al servidor Flask
            $response = $client->post('http://127.0.0.1:5000/verificar', [
                'json' => $data
            ]);
    
            // Obtener y decodificar la respuesta de Flask
            $responseData = json_decode($response->getBody()->getContents(), true);
    
            // Devolver la respuesta al cliente
            return response()->json([
                'success' => true,
                'data' => $responseData
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Manejo de errores 400 desde Flask (por ejemplo, que las imágenes no coincidan)
            $error = json_decode($e->getResponse()->getBody(), true);
            return response()->json([
                'success' => false,
                'error' => $error['error'] ?? 'Error desconocido desde el servidor Flask'
            ], 400);
        } catch (\Exception $e) {
            // Manejo de errores de conexión u otros fallos graves
            return response()->json([
                'success' => false,
                'error' => 'No se pudo conectar al servidor de verificación'
            ], 500);
        }
    }
    
}
