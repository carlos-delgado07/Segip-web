<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class VerificarCIController extends Controller
{
    /**
     * Mostrar formulario para subir imagen.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('upload'); // Vista del formulario con 2 imágenes
    }

    /**
     * Comparar dos imágenes y enviar al servidor Flask.
     */
    public function compararImagen(Request $request)
    {
        // ✅ Validar ambas imágenes
        $request->validate([
            'imagen1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagen2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // 📷 Obtener ambas imágenes
        $imagen1 = $request->file('imagen1');
        $imagen2 = $request->file('imagen2');
    
        // 🔄 Convertir ambas imágenes a base64
        $base64Imagen1 = base64_encode(file_get_contents($imagen1->getPathName()));
        $base64Imagen2 = base64_encode(file_get_contents($imagen2->getPathName()));
    
        // 📨 Preparar el payload con ambas imágenes
        $data = [
            'imagen1' => $base64Imagen1,
            'imagen2' => $base64Imagen2,
        ];
    
        // 🚀 Enviar solicitud a Flask
        $client = new Client();
        try {
            $response = $client->post('http://127.0.0.1:5000/verificar', [
                'json' => $data
            ]);
    
            $responseData = json_decode($response->getBody()->getContents(), true);
    
            return view('resultado', ['response' => $responseData]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Captura errores 400 desde Flask (como nombres no coinciden)
            $errorBody = json_decode($e->getResponse()->getBody(), true);
            return view('resultado', [
                'response' => [
                    'error' => $errorBody['error'] ?? 'Error desconocido desde el servidor de verificación.'
                ]
            ]);
        } catch (\Exception $e) {
            // Errores de conexión u otros fallos graves
            return view('resultado', [
                'response' => ['error' => 'No se pudo conectar al servidor de verificación.']
            ]);
        }
    }
    
}
