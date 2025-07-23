<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\VerificacionDocumento;

class VerificarDocumentoJudicialControllerApi extends Controller
{
    public function verificarDocumento(Request $request)
    {
        // Validar que se reciba una imagen válida
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // máximo 10MB
        ]);

        $imagen = $request->file('imagen');

        // Crear cliente HTTP para consumir el servicio Flask
        $client = new Client();

        try {
            $response = $client->request('POST', 'http://localhost:5000/verificar_documento_file', [
                'multipart' => [
                    [
                        'name'     => 'imagen',
                        'contents' => fopen($imagen->getPathname(), 'r'),
                        'filename' => $imagen->getClientOriginalName(),
                    ],
                ],
                'timeout' => 60,
            ]);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // Guardar en base de datos el resultado (opcional: vincular con usuario autenticado si aplica)
            VerificacionDocumento::create([
                'usuario_id' => auth()->check() ? auth()->id() : null,
                'resultado' => $data['valido'] ? 'válido' : 'inválido',
            ]);

            // Preparar mensaje para respuesta
            $mensaje = $data['valido']
                ? '✅ Recibido correctamente. Su documento judicial será respondido en un periodo de 3 a 7 días.'
                : '❌ El documento no fue reconocido como judicial. Intente con otro documento.';

            // Responder con JSON claro para la app cliente
            return response()->json([
                'success' => true,
                'valido' => $data['valido'],
                'mensaje' => $mensaje,
            ], 200);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json([
                'success' => false,
                'error' => 'No se pudo conectar al servidor de verificación o hubo un error.',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error inesperado: ' . $e->getMessage(),
            ], 500);
        }
    }
}
