<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        'user_id',
        'NombreP',
        'Descripcion',
        'Precio',
        'stock',
        'categoria_id',
        'proveedor_id',
        
    ];

    // Definir la relación con Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Definir la relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Definir la relación con Ventas (opcional)
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
