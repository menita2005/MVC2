<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        // Verificar el tipo de usuario
        $userType = auth()->user()->usertype;
    
        // Obtener Categorias de la API
        $response = Http::get("https://wallinventary.azurewebsites.net/api/Categoria");
    
        if ($response->successful()) {
            // Obtener todas las categorías desde la API
            $categorias = $response->json();
        } else {
            $categorias = [];
        }
    
        // Filtrar categorías según el tipo de usuario
        if ($userType === 'admin') {
            // Mostrar todas las categorías para el administrador
            $categorias = collect($categorias);
        } else {
            // Mostrar solo las categorías activas para otros usuarios
            $categorias = collect($categorias)->where('status', true)->values();
        }
    
        if ($categorias->isEmpty()) {
            return view('categorias.index')->with('message', 'No hay categorías disponibles.');
        }
    
        return view('categorias.index', compact('categorias'));
    }
    public function toggleStatus($id)
{
    // Buscar el categoria por ID
    $categoria = Categoria::findOrFail($id);

    // Cambiar el estado (invertirlo)
    $categoria->status = !$categoria->status;

    // Guardar el categoria actualizado
    $categoria->save();

    // Redireccionar de vuelta a la lista de categoriaes con un mensaje de éxito
    return redirect()->route('categorias.index')->with('success', 'Estado del categoria actualizado exitosamente.');
}
public function edit($id)
{
    // Buscar la categoría por ID
    $categoria = Categoria::find($id);

    if (!$categoria) {
        return redirect()->route('categorias.index')->with('error', 'Categoría no encontrada.');
    }

    // Obtener todas las categorías de la API
    $response = Http::get("https://wallinventary.azurewebsites.net/api/Categoria");

    if ($response->successful()) {
        $categorias = $response->json();
    } else {
        $categorias = [];
    }

    return view('categorias.edit', compact('categoria', 'categorias'));
}


    public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // Agregar el user_id a los datos validados
        $validatedData = $validator->validated();
        $validatedData['user_id'] = $userId;

        // Crear el nuevo Categoria usando los datos validados
        $categoria = Categoria::create($validatedData);

        if (!$categoria) {
            return redirect()->back()->with('error', 'Error al crear la categoría.');
        }

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria = Categoria::findOrFail($id);
        $categoria->update($validator->validated());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Categoría no encontrada.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
