<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trabajador extends Authenticatable
{
    use HasFactory, Notifiable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trabajadores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario',
        'password',
        'nombre_completo',
        'apellidos',
        'dni',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the blogs for the trabajador.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Obtener los productos creados por el trabajador.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}