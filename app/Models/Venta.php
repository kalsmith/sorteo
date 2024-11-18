<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['tienda_id', 'nombre_cliente', 'email_cliente'];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }
}