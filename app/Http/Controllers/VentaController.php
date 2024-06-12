<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Obtener las ventas del usuario desde la base de datos local
        $ventas = Venta::where('user_id', $user->id)->get();

        // Obtener los productos del usuario desde la base de datos local
        $productos = Producto::where('user_id', $user->id)->get();

        return view('ventas.index', compact('ventas', 'productos'));
    }

    public function store(Request $request)
{
    // Validar los datos de entrada
    $validator = Validator::make($request->all(), [
        'producto_id' => 'required|exists:productos,id',
        'c_compra' => 'required|integer|min:1',
    ]);

    // Manejar el caso en que la validación falla
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Obtener el ID del usuario autenticado
    $userId = auth()->id();

    // Agregar el user_id a los datos validados
    $validatedData = $validator->validated();
    $validatedData['user_id'] = $userId;

    // Obtener el producto
    $producto = Producto::find($validatedData['producto_id']);

    // Verificar si la cantidad de la venta es mayor que la disponible en stock
    if ($validatedData['c_compra'] > $producto->stock) {
        return redirect()->back()->with('error', 'No hay suficientes productos en stock para realizar la venta.');
    }

    // Calcular el valor total de la venta
    $valorTotal = $producto->Precio * $validatedData['c_compra'];

    // Restar la cantidad vendida del stock del producto
    $producto->stock -= $validatedData['c_compra'];
    $producto->save();

    // Crear la venta
    Venta::create([
        'v_venta' => $valorTotal,
        'f_venta' => now(), // Fecha actual
        'producto_id' => $validatedData['producto_id'],
        'c_compra' => $validatedData['c_compra'],
        'user_id' => $userId, // Agregar el user_id
    ]);

    // Redirigir de vuelta a la página de ventas con un mensaje de éxito
    return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
}


    public function destroy($id)
    {
        // Buscar la venta por su ID
        $venta = Venta::findOrFail($id);
    
        // Verificar si el usuario autenticado es el propietario de la venta
        if ($venta->user_id !== auth()->id()) {
            // Redirigir con un mensaje de error si el usuario no es el propietario de la venta
            return redirect()->route('ventas.index')->with('error', 'No tienes permiso para eliminar esta venta.');
        }
    
        // Restaurar la cantidad vendida del stock del producto
        $producto = Producto::findOrFail($venta->producto_id);
        $producto->stock += $venta->c_compra;
        $producto->save();
    
        // Eliminar la venta
        $venta->delete();
    
        // Redirigir de vuelta a la página de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }
    

}
