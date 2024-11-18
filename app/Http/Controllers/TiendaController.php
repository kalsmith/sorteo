<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(){
        $title = "Tiendas";
        $tiendas = Tienda::get();
        return view('back.tiendas.index', compact('title','tiendas'));
    }

    public function create(){
        $title = "Crear Tienda";
        $usuarios = User::get();
        return view('back.tiendas.crear', compact('title','usuarios'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id', // Asegura que el ID del usuario exista en la tabla users
        ]);

        Tienda::create([
            'nombre' => $request->nombre,
            'user_id' => $request->user_id,
        ]);
        return redirect()->route('tiendas.index')->with('success', 'Tienda creada exitosamente.');
    }


    public function edit(string $id)
    {
        $tienda = Tienda::findOrFail($id);
        $title =  "Editar: " .$tienda->nombre;
        $usuarios = User::all();

        return view('back.tiendas.edit', compact('usuarios','tienda', 'title'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'user_id' => 'required',

        ]);
    
        $update_tienda = Tienda::findOrFail($id);
    
        
        $formInput=$request->all();
        $update_tienda->update($formInput);

        return redirect()->route('tiendas.index')->with('success', 'Producto actualizado exitosamente.');
  
    }

}
