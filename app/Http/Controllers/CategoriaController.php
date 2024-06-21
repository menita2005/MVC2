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
        // Obtener Categorias de la API
        $response = Http::get("http://localhost/ApiRestProjet/ApiRestSgi/public/api/Categoria");
        
        if ($response->successful()) {
            // Obtener todas las categorías desde la API
            $categorias = $response->json();
        } else {
            $categorias = [];
        }

        if (empty($categorias)) {
            return view('categorias.index', compact('categorias'))->with('message', 'No hay categorías disponibles.');
        }

        return view('categorias.index', compact('categorias'));
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
