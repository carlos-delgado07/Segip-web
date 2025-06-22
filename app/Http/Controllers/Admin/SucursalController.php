<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use App\Models\Municipio;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Ventanilla;
use Illuminate\Support\Facades\Log;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::with('municipio')->get();
        return view('admin.sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        $municipios = Municipio::all();
        $servicios = Servicio::all();
        return view('admin.sucursales.create', compact('municipios', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'nullable|string|max:20',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'municipio_id' => 'required|exists:municipio,id',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicio,id',
        ]);

        $sucursal = Sucursal::create($request->only([
            'nombre',
            'direccion',
            'telefono',
            'latitud',
            'longitud',
            'municipio_id'
        ]));

        if ($request->has('servicios')) {
            $sucursal->servicios()->sync($request->servicios);
        }

        return redirect()->route('admin.sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }

    public function edit(Sucursal $sucursal)
    {
        $municipios = Municipio::all();
        $servicios = Servicio::all();
        $sucursal->load('servicios');
        return view('admin.sucursales.edit', compact('sucursal', 'municipios', 'servicios'));
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'nullable|string|max:20',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'municipio_id' => 'required|exists:municipio,id',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicio,id',
        ]);

        $sucursal->update($request->only([
            'nombre',
            'direccion',
            'telefono',
            'latitud',
            'longitud',
            'municipio_id'
        ]));

        $sucursal->servicios()->sync($request->servicios ?? []);

        return redirect()->route('admin.sucursales.index')->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->servicios()->detach();
        $sucursal->delete();

        return redirect()->route('admin.sucursales.index')->with('success', 'Sucursal eliminada correctamente.');
    }

    public function ventanillas(Sucursal $sucursal)
    {
        $funcionarios = User::role('FUNCIONARIO')->get();
        $ventanillas = $sucursal->ventanillas()->with('user')->get();
        return view('admin.sucursales.ventanillas', compact('sucursal', 'ventanillas', 'funcionarios'));
    }

    public function guardarVentanillas(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'ventanillas.*.nombre' => 'nullable|string|max:255',
            'ventanillas.*.estado' => 'nullable|in:disponible,fuera de servicio',
            'ventanillas.*.user_id' => 'nullable|exists:users,id',
            'ventanillas.*.id' => 'nullable|exists:ventanilla,id',
            'ventanillas.*._delete' => 'nullable|in:true,false'
        ]);

        foreach ($request->ventanillas as $data) {

            // Eliminar
            if (!empty($data['_delete']) && $data['_delete'] === 'true') {
                if (!empty($data['id']) && is_numeric($data['id'])) {
                    $ventanilla = Ventanilla::find((int)$data['id']);
                    if ($ventanilla && $ventanilla->sucursal_id === $sucursal->id) {                        
                        $ventanilla->delete();
                    } else {
                        Log::warning("No se encontró la ventanilla para eliminar o no pertenece a la sucursal.");
                    }
                }
                continue;
            }

            // Actualizar
            if (!empty($data['id']) && is_numeric($data['id'])) {
                $ventanilla = Ventanilla::where('id', (int) $data['id'])
                    ->where('sucursal_id', $sucursal->id)
                    ->first();

                if ($ventanilla) {
                    $ventanilla->update([
                        'nombre' => $data['nombre'],
                        'estado' => $data['estado'],
                        'user_id' => $data['user_id'] ?? null
                    ]);
                }
            } else {
                // Crear
                $sucursal->ventanillas()->create([
                    'nombre' => $data['nombre'],
                    'estado' => $data['estado'],
                    'user_id' => $data['user_id'] ?? null
                ]);
            }
        }

        return redirect()->route('admin.sucursales.index')->with('success', 'Ventanillas actualizadas.');
    }
}
