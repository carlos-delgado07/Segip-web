<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\VerificacionDocumento;

class DocumentoJudicialWebController extends Controller
{
    public function formulario()
    {
        return view('documento.formulario');
    }

    public function verificar(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $imagen = $request->file('imagen');

        try {
            $client = new Client();

            $response = $client->request('POST', 'http://localhost:5000/verificar_documento_file', [
                'multipart' => [
                    [
                        'name'     => 'imagen',
                        'contents' => fopen($imagen->getPathname(), 'r'),
                        'filename' => $imagen->getClientOriginalName(),
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            VerificacionDocumento::create([
                'usuario_id' => auth()->check() ? auth()->id() : null,
                'resultado' => $data['valido'] ? 'válido' : 'inválido',
            ]);

            $mensaje = $data['valido']
                ? '✅ Recibido correctamente. Su documento judicial será respondido en un periodo de 3 a 7 días.'
                : '❌ El documento no fue reconocido como judicial. Intente con otro documento.';

            return view('documento.respuesta', ['mensaje' => $mensaje]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al verificar el documento: ' . $e->getMessage()]);
        }
    }
}
