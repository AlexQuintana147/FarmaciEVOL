<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trabajador;

class Producto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'categoria',
        'descripcion',
        'imagen',
        'trabajador_id',
    ];

    /**
     * Relación con el trabajador que creó el producto.
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}