<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Oferta;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal
     */
    public function index()
    {
        // Obtener los blogs más recientes
        $blogs = Blog::latest()->get();
        
        // Obtener ofertas del mes actual
        $mesActual = Carbon::now();
        $ofertasDelMes = Oferta::whereMonth('created_at', $mesActual->month)
                              ->whereYear('created_at', $mesActual->year)
                              ->latest()
                              ->get();
        
        return view('home', compact('blogs', 'ofertasDelMes'));
    }
}