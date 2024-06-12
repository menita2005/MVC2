<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
       protected $fillable =  [
             'user_id',
            'v_venta',
            'f_venta',
            'producto_id',
            'c_compra',
           
           
       ];
   
       // Relación con el modelo Producto
       public function producto()
       {
           return $this->belongsTo(Producto::class);
       }
}
