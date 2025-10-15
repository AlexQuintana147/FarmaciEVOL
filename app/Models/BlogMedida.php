<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogMedida extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barra_de_blogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trabajador_id',
        'titulo',
        'contenido',
        'valoracion',
        'recomendacion'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valoracion' => 'integer',
    ];

    /**
     * Get the trabajador that owns the blog measure.
     */
    public function trabajador(): BelongsTo
    {
        return $this->belongsTo(Trabajador::class);
    }

    /**
     * Get the blog associated with this measure.
     */
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'id_blog');
    }
}
