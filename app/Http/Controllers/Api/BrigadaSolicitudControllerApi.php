<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrigadaSolicitud;
use Illuminate\Support\Facades\Auth;

class BrigadaSolicitudControllerApi extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'municipio_id' => 'nullable|exists:municipio,id',
        ]);

        $userId = Auth::check() ? Auth::id() : $request->user_id ?? null;

        $solicitud = BrigadaSolicitud::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'estado' => 'pendiente',
            'user_id' => $userId,
            'municipio_id' => $request->municipio_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitud enviada correctamente',
            'data' => $solicitud
        ]);
    }
}
