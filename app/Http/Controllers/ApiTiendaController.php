<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;

class ApiTiendaController extends Controller
{
    public function index(){

        return response()->json(Tienda::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $tienda = Tienda::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Tienda creada exitosamente.',
            'data' => $tienda,
            ], 201); 
    }

    public function edit(string $id)
    {

        $tienda = Tienda::findOrFail($id);


        return response()->json([
            'success' => true,
            'message' => 'Datos de la tienda obtenidos exitosamente.',
            'data' => $tienda,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $tienda = Tienda::findOrFail($id);
        $tienda->update($validatedData);


        return response()->json([
            'success' => true,
            'message' => 'Tienda actualizada exitosamente.',
            'data' => $tienda,
        ], 200);
    }


}
