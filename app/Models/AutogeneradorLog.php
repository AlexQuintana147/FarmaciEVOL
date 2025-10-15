<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trabajador;

class AutogeneradorLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'autogenerador_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trabajador_id',
        'titulo',
        'descripcion',
    ];

    /**
     * Relación con el trabajador que utilizó el autogenerador.
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}