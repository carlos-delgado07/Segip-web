<?php

namespace App\Http\Controllers;

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

class FichaController extends Controller
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
            // Generar QR base64 para la vista
            $builder = new Builder(
                writer: new PngWriter(),
                data: route('ficha.ver', ['codigo' => $fichaExistente->codigo]),
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 150,
                margin: 10
            );

            $qrResult = $builder->build();
            $qrUrl = 'data:image/png;base64,' . base64_encode($qrResult->getString());

            return view('ficha_existente', compact('fichaExistente', 'qrUrl'));
        }

        // Crear nueva ficha
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

        // Generar QR para la ficha
        $builder = new Builder(
            writer: new PngWriter(),
            data: route('ficha.ver', ['codigo' => $ficha->codigo]),
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 150,
            margin: 10
        );

        $qrResult = $builder->build();
        $qrUrl = 'data:image/png;base64,' . base64_encode($qrResult->getString());

        return view('ficha', compact('ficha', 'qrUrl'));
    }

    public function verFicha($codigo)
    {
        $ficha = Ficha::where('codigo', $codigo)->firstOrFail();

        $builder = new Builder(
            writer: new PngWriter(),
            data: route('ficha.ver', $ficha->codigo),
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10
        );

        $qrResult = $builder->build();

        // 🔧 CORREGIDO: Guardar en el disco "public"
        $qrPath = 'qr/ficha_' . $ficha->codigo . '.png';
        Storage::disk('public')->put($qrPath, $qrResult->getString());

        // 🌐 URL pública del QR
        $qrUrl = asset('storage/' . $qrPath);

        return view('ficha_publica', compact('ficha', 'qrUrl'));
    }
}
