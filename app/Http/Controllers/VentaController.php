<?php

namespace App\Http\Controllers;

use App\Mail\mailGanador;
use App\Mail\ticketTienda;
use App\Models\Tienda;
use Illuminate\Support\Facades\Auth;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VentaController extends Controller
{
    public function index(){
        $title = "Mis Ventas";
        $id_tienda = Tienda::where('user_id', Auth::id())->first();
        if ($id_tienda != null) {
            $ventas = Venta::where('tienda_id',$id_tienda->id)->get();
            return view('back.ventas.index', compact('title','ventas','id_tienda'));
        }else {
            $ventas = null;
            return view('back.ventas.index', compact('title','ventas','id_tienda'));
        }




    }

    public function create(){
        $title = "Crear Venta";
        $id_tienda = Tienda::where('user_id', Auth::id())->first();
        return view('back.ventas.crear', compact('title','id_tienda'));
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
        return redirect()->route('ventas.index')->with('success', 'Tienda creada exitosamente.');
    }


    public function sorteo()
    {
        $title = "Sorteo";
        return view('back.sorteo.index', compact('title'));
    }

    public function sorteoNumero()
    {
        $ventaAleatoria = Venta::inRandomOrder()->first();
        return $ventaAleatoria;
    }

    public function sendMail(Request $request)
    {

        Mail::to($request->mail)->send(new mailGanador('Estimado(a) ' . $request->cliente . ', Has ganado !!!, Gracias por participar.'));
        
    }

   
}
