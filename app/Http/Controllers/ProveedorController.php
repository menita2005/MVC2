<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    public function index()
{
    // Obtener proveedores de la API
    $response = Http::get("http://localhost/ApiRestProjet/ApiRestSgi/public/api/Proveedors");
    
    // Verificar si la respuesta es exitosa y es un array
    if ($response->successful() && is_array($response->json())) {
        $proveedores = $response->json();
    } else {
        $proveedores = [];
    }

    // Verificar si no hay proveedores
    if (empty($proveedores)) {
        return view('proveedors.index')->with('message', 'No hay proveedores disponibles.');
    }

    return view('proveedors.index', compact('proveedores'));
}


    public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // Agregar el user_id a los datos validados
        $validatedData = $validator->validated();
        $validatedData['user_id'] = $userId;

        // Crear el nuevo proveedor usando los datos validados
        $proveedor = Proveedor::create($validatedData);

        if (!$proveedor) {
            return redirect()->back()->with('error', 'Error al crear el proveedor.');
        }

        return redirect()->route('proveedors.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }

        return response()->json($proveedor);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($validator->validated());

        return redirect()->route('proveedors.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return redirect()->route('proveedors.index')->with('error', 'Proveedor no encontrado.');
        }

        $proveedor->delete();

        return redirect()->route('proveedors.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
