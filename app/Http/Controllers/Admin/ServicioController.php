<?php

namespace App\Http\Controllers\Admin;

use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tiempo_estimado' => 'required|integer|min:1',
        ]);

        Servicio::create($request->only('nombre', 'tiempo_estimado'));

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tiempo_estimado' => 'required|integer|min:1',
        ]);

        $servicio->update($request->only('nombre', 'tiempo_estimado'));

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio eliminado.');
    }
}
