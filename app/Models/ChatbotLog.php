<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotLog extends Model
{
    use HasFactory;

    protected $table = 'chatbot_logs';

    protected $fillable = [
        'trabajador_id',
        'pregunta',
        'respuesta',
        'es_autenticado'
    ];

    /**
     * Relación con el modelo Trabajador
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}
