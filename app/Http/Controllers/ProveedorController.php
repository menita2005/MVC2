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
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Obtener proveedors de la API
        $response = Http::get("http://localhost/ApiRestProjet/ApiRestSgi/public/api/Proveedors");
        
        // Filtrar proveedors por el user_id del usuario autenticado
        $proveedores = collect($response->json())->filter(function ($proveedores) use ($user) {
            return $proveedores['user_id'] == $user->id;
        })->values()->all();

        

        return view('proveedors.index', compact('proveedores'));
    }

//     public function store(Request $request)
// {
//     $request->merge(['user_id' => Auth::id()]);

//     // Realizar la solicitud a la API para crear el proveedor
//     $response = Http::post("http://localhost/ApiRestProjet/ApiRestSgi/public/api/proveedors", $request->all());

//     // Verificar si la solicitud fue exitosa
//     if ($response->successful()) {
//         // Redirigir de vuelta a la página de proveedors con un mensaje de éxito
//         return redirect()->route('proveedors.index')->with('success', '¡El proveedor se ha creado exitosamente!');
//     } else {
//         // Manejar el caso en que la solicitud no fue exitosa
//         return redirect()->route('proveedors.index')->with('error', 'Ha ocurrido un error al crear el proveedor. Por favor, intenta de nuevo.');
//     }
// }
public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'correo' => 'required|string'
           
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
    
        // Crear el nuevo proveedor usando los datos validados
        $proveedor = Proveedor::create($validatedData);
    
        if (!$proveedor) {
            $data = [
                'message' => 'Error al crear el proveedor',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
    
       
    
        $data = [
            'proveedor' => $proveedor,
            'status' => 201
        ];
        return redirect()->route('proveedors.index')->with('success', 'proveedor creado exitosamente');
    }


    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        return response()->json($proveedor);
    }

    public function update(Request $request, $id)
    {
        $proveedor = proveedor::findOrFail($id);
        $proveedor->update($request->all());
        return redirect()->route('proveedors.index')->with('success', 'proveedor creado exitosamente');
    }

    public function destroy($id)
    {
        proveedor::destroy($id);
        return redirect()->route('proveedors.index')->with('success', 'proveedor creado exitosamente');
    }
}