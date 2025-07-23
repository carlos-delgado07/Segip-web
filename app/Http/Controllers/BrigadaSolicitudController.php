<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrigadaSolicitud;
use Illuminate\Support\Facades\Auth;

class BrigadaSolicitudController extends Controller
{
    public function create()
    {
        // Mostrar el formulario de solicitud
        return view('brigada.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'municipio_id' => 'nullable|exists:municipio,id',
        ]);

        $userId = Auth::check() ? Auth::id() : null;

        BrigadaSolicitud::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'estado' => 'pendiente',
            'user_id' => $userId,
            'municipio_id' => $request->municipio_id,
        ]);

        return redirect()->route('brigada.create')->with('success', 'Su solicitud de brigada móvil ha sido enviada y será procesada.');
    }
}
