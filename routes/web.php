<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TrabajadorAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatbotLogController;
use App\Http\Controllers\AutogeneradorLogController;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Chatbot Routes - Accesible para todos
Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');
Route::post('/chatbot/logs', [ChatbotLogController::class, 'store'])->name('chatbot.logs.store');
Route::get('/chatbot/historial', [ChatbotLogController::class, 'historial'])->name('chatbot.historial');

Route::get('/nosotros', function () {
    return view('nosotros');
});

Route::get('/farmacovigilancia', function () {
    return view('farmacovigilancia');
});

Route::get('/productos', function () {
    $productos = App\Models\Producto::all();
    $ultimoProducto = App\Models\Producto::latest()->first();
    return view('productos', compact('productos', 'ultimoProducto'));
});

Route::get('/blog', function () {
    $blogs = App\Models\Blog::with('trabajador')->latest()->get();
    $ultimoBlog = App\Models\Blog::with('trabajador')->latest()->first();
    return view('blog', compact('blogs', 'ultimoBlog'));
});

//Trabajadores
Route::middleware('guest:trabajador')->group(function () {
    Route::get('/login', [TrabajadorAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [TrabajadorAuthController::class, 'login']);
});
Route::post('/logout', [TrabajadorAuthController::class, 'logout'])->name('logout');

//Auth
Route::middleware(['auth:trabajador'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Chatbot Metrics
    Route::get('/dashboard/chatbot-metrics', [ChatbotController::class, 'metrics'])->name('chatbot.metrics');
    Route::get('/dashboard/chatbot-metrics/export', [App\Http\Controllers\ChatbotExportController::class, 'export'])->name('chatbot.metrics.export');
    
    // Blog Metrics
    Route::get('/dashboard/blog-metrics', [App\Http\Controllers\BlogMedidaController::class, 'metrics'])->name('blog.metrics');
    
    // Autogenerador Logs
    Route::get('/dashboard/autogenerador-logs', [AutogeneradorLogController::class, 'index'])->name('autogenerador.logs');
    Route::get('/dashboard/autogenerador-logs/export', [App\Http\Controllers\AutogeneradorExportController::class, 'export'])->name('autogenerador.logs.export');
    Route::get('/dashboard/autogenerador-logs/{log}', [AutogeneradorLogController::class, 'show'])->name('autogenerador.logs.show');
    
    //Blogs
    Route::get('/dashboard/blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('dashboard.blogs');
    Route::get('/dashboard/blogs/export', [App\Http\Controllers\BlogExportController::class, 'export'])->name('blogs.export');
    Route::post('/dashboard/blogs/medir', [App\Http\Controllers\BlogMedidaController::class, 'evaluateContent'])->name('blogs.medir');
    Route::get('/dashboard/blogs/create', [App\Http\Controllers\BlogController::class, 'create'])->name('blogs.create');
    Route::post('/dashboard/blogs', [App\Http\Controllers\BlogController::class, 'store'])->name('blogs.store');
    Route::get('/dashboard/blogs/{blog}', [App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/dashboard/blogs/{blog}/edit', [App\Http\Controllers\BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/dashboard/blogs/{blog}', [App\Http\Controllers\BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/dashboard/blogs/{blog}', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blogs.destroy');
    
    //Productos
    Route::get('/dashboard/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('dashboard.productos');
    Route::get('/dashboard/productos/export', [App\Http\Controllers\ProductoExportController::class, 'export'])->name('productos.export');
    Route::get('/dashboard/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
    Route::post('/dashboard/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
    Route::get('/dashboard/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'show'])->name('productos.show');
    Route::get('/dashboard/productos/{producto}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/dashboard/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/dashboard/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');
    
    // Generador de descripción de productos
    Route::post('/generar-descripcion', [App\Http\Controllers\ProductoDescripcionGeneradorController::class, 'generar'])
        ->name('generar.descripcion')
        ->middleware('auth:trabajador');
    
    //Ofertas
    Route::get('/dashboard/ofertas', [App\Http\Controllers\Dashboard\OfertaController::class, 'index'])->name('dashboard.ofertas');
    Route::get('/dashboard/ofertas/create', [App\Http\Controllers\Dashboard\OfertaController::class, 'create'])->name('ofertas.create');
    Route::post('/dashboard/ofertas', [App\Http\Controllers\Dashboard\OfertaController::class, 'store'])->name('ofertas.store');
    Route::get('/dashboard/ofertas/{oferta}', [App\Http\Controllers\Dashboard\OfertaController::class, 'show'])->name('ofertas.show');
    Route::get('/dashboard/ofertas/{oferta}/edit', [App\Http\Controllers\Dashboard\OfertaController::class, 'edit'])->name('ofertas.edit');
    Route::put('/dashboard/ofertas/{oferta}', [App\Http\Controllers\Dashboard\OfertaController::class, 'update'])->name('ofertas.update');
    Route::delete('/dashboard/ofertas/{oferta}', [App\Http\Controllers\Dashboard\OfertaController::class, 'destroy'])->name('ofertas.destroy');
    
    //Trabajadores-Dash
    Route::get('/dashboard/trabajadores', [App\Http\Controllers\TrabajadorController::class, 'index'])->name('dashboard.trabajadores');
    Route::get('/dashboard/trabajadores/create', [App\Http\Controllers\TrabajadorController::class, 'create'])->name('trabajadores.create');
    Route::post('/dashboard/trabajadores', [App\Http\Controllers\TrabajadorController::class, 'store'])->name('trabajadores.store');
    Route::get('/dashboard/trabajadores/{trabajador}', [App\Http\Controllers\TrabajadorController::class, 'show'])->name('trabajadores.show');
    Route::get('/dashboard/trabajadores/{trabajador}/edit', [App\Http\Controllers\TrabajadorController::class, 'edit'])->name('trabajadores.edit');
    Route::put('/dashboard/trabajadores/{trabajador}', [App\Http\Controllers\TrabajadorController::class, 'update'])->name('trabajadores.update');
    Route::delete('/dashboard/trabajadores/{trabajador}', [App\Http\Controllers\TrabajadorController::class, 'destroy'])->name('trabajadores.destroy');
});
