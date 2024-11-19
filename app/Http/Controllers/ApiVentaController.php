<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class ApiVentaController extends Controller
{
    public function index(){

        return response()->json(Venta::all(), 200);
    }
}
