<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompraController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener las compras del usuario autenticado
        $compras = Compra::all();

        // Obtener los proveedores del usuario autenticado
        $proveedores = Proveedor::all();

        // Obtener los productos del usuario autenticado
        $productos = Producto::all();

        // Verificar si hay compras disponibles
        if ($compras->isEmpty()) {
            return view('compras.index', compact('compras', 'proveedores', 'productos'))->with('message', 'No hay compras disponibles.');
        }

        return view('compras.index', compact('compras', 'proveedores', 'productos'));
    }

    public function create()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Obtener todos los proveedores
        $proveedores = Proveedor::all();
        
        // Filtrar los proveedores activos
        $proveedores = collect($proveedores)->where('status', true);
    
        // Obtener los productos del usuario autenticado
        $productos = Producto::where('user_id', $user->id)->get();
    
        return view('compras.create', compact('proveedores', 'productos'));
    }
    


    public function store(Request $request)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedors,id',
            'producto_id' => 'required|exists:productos,id',
            'c_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // Obtener el producto seleccionado
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Calcular el valor de la compra
        $valorCompra = $producto->Precio * $request->c_compra;

        // Crear la nueva compra usando los datos validados
        $compra = Compra::create([
            'user_id' => $userId,
            'proveedor_id' => $request->proveedor_id,
            'producto_id' => $request->producto_id,
            'c_compra' => $request->c_compra,
            'v_compra' => $valorCompra,
            'f_compra' => now(),
        ]);

        if (!$compra) {
            return redirect()->back()->with('error', 'Error al crear la compra.');
        }

        // Actualizar la cantidad del producto en la base de datos
        $producto->update([
            'stock' => $producto->stock + $request->c_compra,
        ]);

        return redirect()->route('compras.index')->with('success', 'Compra creada exitosamente.');
    }

    public function show($id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json(['message' => 'Compra no encontrada'], 404);
        }

        return response()->json($compra);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos entrantes de la solicitud
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedors,id',
            'producto_id' => 'required|exists:productos,id',
            'c_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el producto seleccionado
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        // Calcular la diferencia de cantidad entre la compra anterior y la actual
        $compraAnterior = Compra::findOrFail($id);
        $diferenciaCantidad = $request->c_compra - $compraAnterior->c_compra;

        // Actualizar la compra
        $compra = Compra::findOrFail($id);
        $compra->update([
            'proveedor_id' => $request->proveedor_id,
            'producto_id' => $request->producto_id,
            'c_compra' => $request->c_compra,
        ]);

        // Actualizar la cantidad del producto en la base de datos
        $producto->update([
            'stock' => $producto->stock + $diferenciaCantidad,
        ]);

        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return redirect()->route('compras.index')->with('error', 'Compra no encontrada.');
        }

        // Obtener el producto asociado a la compra
        $producto = Producto::find($compra->producto_id);

        if ($producto) {
            // Restar la cantidad de la compra eliminada del total del producto
            $producto->update([
                'cantidad' => $producto->cantidad - $compra->c_compra,
            ]);
        }

        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente.');
    }
    // EDIT //

    public function edit($id)
{
    // Obtener la compra por su ID
    $compra = Compra::find($id);

    if (!$compra) {
        return redirect()->route('compras.index')->with('error', 'Compra no encontrada.');
    }

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Obtener los proveedores del usuario autenticado
    $proveedores = Proveedor::where('user_id', $user->id)->get();

    // Obtener los productos del usuario autenticado
    $productos = Producto::where('user_id', $user->id)->get();

    // Redirigir a la vista de edición de la compra con los datos necesarios
    return view('compras.edit', compact('compra', 'proveedores', 'productos'));
}
}

