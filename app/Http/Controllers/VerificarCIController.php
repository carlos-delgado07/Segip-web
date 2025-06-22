<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Ficha;
use Carbon\Carbon;

class VerificarCIController extends Controller
{
    public function showForm()
    {
        return view('upload');
    }

    public function compararImagen(Request $request)
    {
        $request->validate([
            'imagen1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagen2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagen1 = $request->file('imagen1');
        $imagen2 = $request->file('imagen2');

        $base64Imagen1 = base64_encode(file_get_contents($imagen1->getPathName()));
        $base64Imagen2 = base64_encode(file_get_contents($imagen2->getPathName()));

        $data = [
            'imagen1' => $base64Imagen1,
            'imagen2' => $base64Imagen2,
        ];

        $client = new Client();

        try {
            $response = $client->post('http://127.0.0.1:5000/verificar', [
                'json' => $data
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            return view('resultado', [
                'response' => $responseData,
                'status' => $response->getStatusCode()
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $errorBody = json_decode($e->getResponse()->getBody(), true);

            if ($statusCode === 403 && isset($errorBody['usuario'])) {
                $nombresRaw = $errorBody['usuario']['nombres'] ?? null;
                $apellidosRaw = $errorBody['usuario']['apellidos'] ?? null;

                if ($nombresRaw && $apellidosRaw) {
                    $fechaBusqueda = Carbon::tomorrow()->toDateString(); // Buscar ficha para el día siguiente

                    // Función para normalizar texto (minúsculas y sin tildes)
                    $normalize = function($text) {
                        return strtolower(
                            preg_replace('/\s+/', ' ', 
                                iconv('UTF-8', 'ASCII//TRANSLIT', trim($text))
                            )
                        );
                    };

                    $nombres = $normalize($nombresRaw);
                    $apellidos = $normalize($apellidosRaw);

                    // Buscar ficha para la fecha siguiente con nombres y apellidos normalizados
                    $fichaExistente = Ficha::whereDate('fecha', $fechaBusqueda)
                        ->get()
                        ->filter(function($ficha) use ($normalize, $nombres, $apellidos) {
                            return $normalize($ficha->nombres) === $nombres
                                && $normalize($ficha->apellidos) === $apellidos;
                        })
                        ->first();

                    if ($fichaExistente) {
                        $qrPath = "qr/ficha_{$fichaExistente->codigo}.png";
                        $qrUrl = asset("storage/{$qrPath}");

                        return view('ficha_existente', [
                            'fichaExistente' => $fichaExistente,
                            'qrUrl' => $qrUrl
                        ]);
                    }
                }

                // Si ya fue verificado pero no hay ficha, mostrar mensaje genérico
                return view('resultado', [
                    'response' => [
                        'error' => '⚠️ Atención: este usuario ya fue verificado hoy, pero no se encontró ficha.'
                    ],
                    'status' => 403
                ]);
            }

            // Otros errores de cliente
            return view('resultado', [
                'response' => [
                    'error' => $errorBody['error'] ?? $errorBody['mensaje'] ?? 'Error desconocido desde el servidor.'
                ],
                'status' => $statusCode
            ]);
        } catch (\Exception $e) {
            return view('resultado', [
                'response' => ['error' => 'No se pudo conectar al servidor de verificación.'],
                'status' => 500
            ]);
        }
    }
}
