<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios activos excepto el administrador
        $users = User::where('usertype', 'Encargado')
                     
                     ->get();
    
        return view('admin.users.index', compact('users'));
    }
    

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Estado del usuario actualizado exitosamente.');
    }
    public function inicio(){
        return view('admin.dashboard');
    }
}

