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
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Obtener Categorias de la API
        $response = Http::get("http://localhost/ApiRestProjet/ApiRestSgi/public/api/Categoria");
        
        // Filtrar Categorias por el user_id del usuario autenticado
        $categorias = collect($response->json())->filter(function ($categorias) use ($user) {
            return $categorias['user_id'] == $user->id;
        })->values()->all();

        

        return view('categorias.index', compact('categorias'));
    }

//     public function store(Request $request)
// {
//     $request->merge(['user_id' => Auth::id()]);

//     // Realizar la solicitud a la API para crear el Categoria
//     $response = Http::post("http://localhost/ApiRestProjet/ApiRestSgi/public/api/Categorias", $request->all());

//     // Verificar si la solicitud fue exitosa
//     if ($response->successful()) {
//         // Redirigir de vuelta a la página de Categorias con un mensaje de éxito
//         return redirect()->route('Categorias.index')->with('success', '¡El Categoria se ha creado exitosamente!');
//     } else {
//         // Manejar el caso en que la solicitud no fue exitosa
//         return redirect()->route('Categorias.index')->with('error', 'Ha ocurrido un error al crear el Categoria. Por favor, intenta de nuevo.');
//     }
// }
public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            
            'Nombre' => 'required|string|max:255'
            
           
        ]);
    
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'error' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
    
        // Obtener el ID del usuario autenticado
        $userId = auth()->id();
    
        // Agregar el user_id a los datos validados
        $validatedData = $validator->validated();
        $validatedData['user_id'] = $userId;
    
        // Crear el nuevo Categoria usando los datos validados
        $Categoria = Categoria::create($validatedData);
    
        if (!$Categoria) {
            $data = [
                'message' => 'Error al crear el Categoria',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
    
       
    
        $data = [
            'Categoria' => $Categoria,
            'status' => 201
        ];
        return redirect()->route('categorias.index')->with('success', 'Categoria creado exitosamente');
    }


    public function show($id)
    {
        $Categoria = Categoria::find($id);
        return response()->json($Categoria);
    }

    public function update(Request $request, $id)
    {
        $Categoria = Categoria::findOrFail($id);
        $Categoria->update($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoria creado exitosamente');
    }

    public function destroy($id)
    {
        Categoria::destroy($id);
        return redirect()->route('categorias.index')->with('success', 'Categoria creado exitosamente');
    }
}
