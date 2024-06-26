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
        $response = Http::get("https://wallinventary.azurewebsites.net/api/Proveedors");
        
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
    
        // Si hay proveedores, verificar el tipo de usuario para filtrar los activos
        if (auth()->user()->usertype === 'admin') {
            // Si es admin, mostrar todos los proveedores
            $proveedores = collect($proveedores); // Convertir colección para poder usar métoa dos de colección
        } else {
            // Si no es admin, filtrar solo los proveedores activos
            $proveedores = collect($proveedores)->where('status', true);
        }
    
        return view('proveedors.index', compact('proveedores'));
    }
    public function toggleStatus($id)
    {
        // Buscar el proveedor por ID
        $proveedor = Proveedor::findOrFail($id);
    
        // Cambiar el estado (invertirlo)
        $proveedor->status = !$proveedor->status;
    
        // Guardar el proveedor actualizado
        $proveedor->save();
    
        // Redireccionar de vuelta a la lista de proveedores con un mensaje de éxito
        return redirect()->route('proveedors.index')->with('success', 'Estado del proveedor actualizado exitosamente.');
    }
    public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:proveedors', // Asegura que el correo sea único en la tabla proveedors
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
            'correo' => 'required|email|max:255|unique:proveedors,correo,'.$id, // Asegura que el correo sea único excluyendo el proveedor actual
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
