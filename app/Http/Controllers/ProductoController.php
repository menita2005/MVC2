<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
class ProductoController extends Controller
{
    public function index()
    {
        // Obtener productos de la API
        $response = Http::get("https://wallinventary.azurewebsites.net/api/productos");

        // Verificar si la respuesta es exitosa y es un array
        if ($response->successful() && is_array($response->json())) {
            $productos = $response->json();
        } else {
            $productos = [];
        }

        // Obtener categorías y proveedores
        $categorias = Http::get("https://wallinventary.azurewebsites.net/api/Categoria")->json();
        $proveedores = Http::get("https://wallinventary.azurewebsites.net/api/Proveedors")->json();

        // Verificar si no hay productos
        if (empty($productos)) {
            return view('productos.index', compact('categorias', 'proveedores'))
                ->with('message', 'No hay productos disponibles.');
        }

        return view('productos.index', compact('productos', 'categorias', 'proveedores'));
    }
    public function create()
{
    $categorias = Http::get("https://wallinventary.azurewebsites.net/api/Categoria")->json();
    $proveedores = Http::get("https://wallinventary.azurewebsites.net/api/Proveedors")->json();
    return view('productos.create', compact('categorias', 'proveedores'));
}
    


public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            
            'NombreP' => 'required|string|max:255',
            'Descripcion' => 'required|string',
            'Precio' => 'required|integer',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedors,id'
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
    
        // Crear el nuevo producto usando los datos validados
        $producto = Producto::create($validatedData);
    
        if (!$producto) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
    
        // Cargar las relaciones 'categoria' y 'proveedor' en el producto creado
        $producto->load(['categoria', 'proveedor']);
    
        $data = [
            'producto' => $producto,
            'status' => 201
        ];
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }


    public function show($id)
    {
        $producto = Producto::find($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    public function destroy($id)
    {
        Producto::destroy($id);
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }
}
