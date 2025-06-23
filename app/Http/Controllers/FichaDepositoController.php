<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ficha;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\Ventanilla;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class FichaDepositoController extends Controller
{

    public function form()
    {
        return view('ficha.solicitar', [
            'servicios' => Servicio::all(),
            'sucursales' => Sucursal::all()
        ]);
    }

    public function ver($codigo)
    {
        $ficha = Ficha::with(['sucursal', 'ventanillaAsignada'])->where('codigo', $codigo)->firstOrFail();
        return view('ficha.detalle', compact('ficha'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicio,id',
            'sucursal_id' => 'required|exists:sucursal,id',
            'deposito' => 'required|image|max:2048',
        ]);

        $user = Auth::user();
        $mañana = Carbon::now('America/La_Paz')->addDay()->toDateString();

        // Verificar ficha existente
        if (Ficha::where('user_id', $user->id)->whereDate('fecha', $mañana)->exists()) {
            return back()->with('error', 'Ya tienes una ficha para mañana.');
        }

        // Enviar imagen a OCR
        $client = new Client();
        $imagenBase64 = base64_encode(file_get_contents($request->file('deposito')->getPathname()));

        try {
            $response = $client->post('http://127.0.0.1:5000/validar_deposito', [
                'json' => ['imagen' => $imagenBase64]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['valido']) || $data['valido'] !== true) {
                return back()->with('error', 'El depósito no es válido o no es de 17 Bs.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al validar el depósito.');
        }

        // Datos necesarios
        $servicio = Servicio::findOrFail($request->servicio_id);
        $sucursal = Sucursal::findOrFail($request->sucursal_id);
        $tiempoEstimado = $servicio->tiempo_estimado;
        $ventanillas = $sucursal->ventanillas()->where('estado', 'disponible')->get();
        $horaInicio = Carbon::createFromTime(7, 0);
        $horaFin = Carbon::createFromTime(15, 0);

        // Cargar fichas ya asignadas en esa sucursal para mañana
        $fichas = Ficha::where('sucursal_id', $sucursal->id)->whereDate('fecha', $mañana)->get();

        $hora = clone $horaInicio;
        $ventanillasArray = $ventanillas->values(); // Para acceder con índice
        $cantidadVentanillas = $ventanillasArray->count();

        while ($hora->lessThan($horaFin)) {
            for ($i = 0; $i < $cantidadVentanillas; $i++) {
                $ventanilla = $ventanillasArray[$i];

                // Verificamos si ya existe una ficha en esa ventanilla y hora
                $yaTomado = $fichas->first(function ($ficha) use ($ventanilla, $hora) {
                    return $ficha->ventanilla_id === $ventanilla->id && $ficha->hora === $hora->format('H:i:s');
                });

                if (!$yaTomado) {
                    $codigo = strtoupper(Str::random(6));

                    $nuevaFicha = Ficha::create([
                        'user_id' => $user->id,
                        'fecha' => $mañana,
                        'hora' => $hora->format('H:i:s'),
                        'ventanilla' => $ventanilla->nombre,
                        'ventanilla_id' => $ventanilla->id,
                        'sucursal_id' => $sucursal->id,
                        'servicio_id' => $servicio->id,
                        'codigo' => $codigo,
                        'nombres' => $user->name,
                        'apellidos' => '',
                        'estado' => 'pendiente',
                    ]);

                    // QR
                    $builder = new Builder(
                        writer: new PngWriter(),
                        data: route('ficha.ver', ['codigo' => $codigo]),
                        encoding: new Encoding('UTF-8'),
                        errorCorrectionLevel: ErrorCorrectionLevel::High,
                        size: 300,
                        margin: 10
                    );

                    $qr = $builder->build();
                    $qrPath = 'qr/ficha_' . $codigo . '.png';
                    Storage::disk('public')->put($qrPath, $qr->getString());

                    return redirect()->route('ficha.detalle', ['codigo' => $codigo]);
                }
            }

            // Aumentamos al siguiente bloque de tiempo
            $hora->addMinutes($tiempoEstimado);
        }


        return back()->with('error', 'No hay horarios disponibles para mañana.');
    }
}
