<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class FichaApiController extends Controller
{
    public function generarFicha(Request $request)
    {
        $user = Auth::user();
        $mañana = now()->addDay()->startOfDay();

        // Verificar si ya tiene ficha para mañana
        $fichaExistente = Ficha::where('user_id', $user->id)
            ->whereDate('fecha', $mañana->toDateString())
            ->first();

        if ($fichaExistente) {
            return response()->json([
                'message' => 'Ya tienes una ficha generada para mañana.',
                'ficha' => $fichaExistente,
                'qr_url' => $this->generarQrUrl($fichaExistente->codigo),
            ]);
        }

        // Asignar hora y ventanilla
        $horaInicio = Carbon::createFromTime(7, 0);
        $turnoDuracion = 15; // minutos
        $fichasDeManana = Ficha::whereDate('fecha', $mañana)->orderBy('id')->get();

        $turnoIndex = $fichasDeManana->count();
        $ventanilla = floor($turnoIndex / 4) % 30 + 1;
        $horaBloque = $turnoIndex % 4;
        $horaTurno = $horaInicio->copy()->addMinutes($horaBloque * $turnoDuracion + floor($turnoIndex / 30) * 60);

        // Generar código único
        do {
            $codigo = strtoupper(Str::random(6));
        } while (Ficha::where('codigo', $codigo)->exists());

        $ficha = Ficha::create([
            'user_id'    => $user->id,
            'fecha'      => $mañana,
            'hora'       => $horaTurno->format('H:i'),
            'ventanilla' => $ventanilla,
            'codigo'     => $codigo,
            'nombres'    => $request->nombres,
            'apellidos'  => $request->apellidos,
        ]);

        return response()->json([
            'message' => 'Ficha generada correctamente.',
            'ficha' => $ficha,
            'qr_url' => $this->generarQrUrl($ficha->codigo),
        ]);
    }

    public function verFicha()
    {
        $user = Auth::user();
        $mañana = now()->addDay()->startOfDay();

        $ficha = Ficha::where('user_id', $user->id)
            ->whereDate('fecha', $mañana->toDateString())
            ->first();

        if (!$ficha) {
            return response()->json(['message' => 'No tienes una ficha registrada para mañana.'], 404);
        }

        return response()->json([
            'ficha' => $ficha,
            'qr_url' => $this->generarQrUrl($ficha->codigo),
        ]);
    }

    private function generarQrUrl($codigo)
    {
        $builder = new Builder(
            writer: new PngWriter(),
            data: route('ficha.ver', $codigo), // Usa la misma URL pública de la web
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10
        );

        $qrResult = $builder->build();
        $qrPath = 'qr/ficha_' . $codigo . '.png';
        Storage::disk('public')->put($qrPath, $qrResult->getString());

        return asset('storage/' . $qrPath);
    }
}
