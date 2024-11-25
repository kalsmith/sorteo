<?php

namespace App\Http\Controllers;

use App\Mail\ticketTienda;
use App\Models\Tienda;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ApiVentaController extends Controller
{
    public function index(){


        $user = Auth::user();
        $id_tienda = Tienda::where('user_id', $user->id)->first();
        if($id_tienda != null){
            $ventas = Venta::where('tienda_id',$id_tienda->id)->get();
        
        // Retornar el nombre del usuario
        return response()->json([
            'message' => 'Mis Ventas',
            'nTienda' => $id_tienda->nombre,
            'Ventas' => $ventas,
        ]);
        }else{
            return response()->json([
                'message' => 'No tienes Tienda Asociada, <strong> Contactate con el Administrador </strong>',
            ]);
        }
      
    }


    public function store(Request $request)
    {

        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'email_cliente' => 'required', // Asegura que el ID del usuario exista en la tabla users
        ]);

        $numero = Venta::create([
            'nombre_cliente' => $request->nombre_cliente,
            'email_cliente' => $request->email_cliente,
            'tienda_id' => $request->tienda_id,
        ]);

        Mail::to($request->email_cliente)->send(new ticketTienda('Estimado(a) ' . $request->nombre_cliente . ', gracias por tu compra. Tienes el número ' . $numero->id . ' para el sorteo en Prácticas y Fetiches.'));

        return response()->json([
            'message' => 'Venta Creada Existosamente',
            'id' => $numero->id
        ]);


    }

}
