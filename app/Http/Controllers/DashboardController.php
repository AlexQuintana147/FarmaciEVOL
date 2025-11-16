<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Producto;
use App\Models\Trabajador;
use App\Models\Oferta;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index()
{
    $stats = [
        'blogs' => Blog::count(),
        'productos' => Producto::count(),
        'trabajadores' => Trabajador::count(),
        'ofertas' => Oferta::count(),
    ];
    
    $recentBlogs = Blog::with('trabajador')->latest()->take(5)->get();
    $recentProductos = Producto::with('trabajador')->latest()->take(5)->get(); // ✓ Agregado
    
    return view('dashboard.index', compact('stats', 'recentBlogs', 'recentProductos'));
}
    
    /**
     * Mostrar la lista de blogs
     */
    public function blogs()
    {
        $blogs = Blog::with('trabajador')->latest()->paginate(10);
        return view('dashboard.blogs.index', compact('blogs'));
    }
    
    /**
     * Mostrar la lista de productos
     */
    public function productos()
    {
        $productos = Producto::latest()->paginate(10);
        return view('dashboard.productos.index', compact('productos'));
    }
}