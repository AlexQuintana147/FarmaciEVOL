<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trabajador_id',
        'titulo',
        'imagen',
    ];
    
    /**
     * Obtiene el trabajador asociado a esta oferta.
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}
