<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ImageUploadService;

class ProductoController extends Controller
{
    /**
     * Mostrar la lista de productos
     */
    public function index(Request $request)
    {
        $query = Producto::with('trabajador')->latest();
        
        // Filtrar por búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
        }
        
        // Filtrar por categoría
        if ($request->has('categoria') && $request->categoria != 'todos') {
            $query->where('categoria', $request->categoria);
        }
        
        $productos = $query->get();
        return view('dashboard.productos.index', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto
     */
    public function create()
    {
        $categorias = ['Medicamentos', 'Vitaminas', 'Cuidado Personal', 'Primeros Auxilios', 'Suplementos'];
        return view('dashboard.productos.create', compact('categorias'));
    }

    /**
     * Almacenar un nuevo producto
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'categoria' => 'required',
            'descripcion' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['trabajador_id'] = auth()->guard('trabajador')->user()->id;

        // ✅ Subida de imagen centralizada
        if ($request->hasFile('imagen')) {
            $imageService = new ImageUploadService();
            $data['imagen'] = $imageService->upload($request->file('imagen'), 'imagesProductos');
        }

        Producto::create($data);

        return redirect()->route('dashboard.productos')
                         ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Mostrar un producto específico
     */
    public function show(Producto $producto)
    {
        $producto->load('trabajador');
        return view('dashboard.productos.show', compact('producto'));
    }

    /**
     * Mostrar el formulario para editar un producto
     */
    public function edit(Producto $producto)
    {
        $categorias = ['Medicamentos', 'Vitaminas', 'Cuidado Personal', 'Primeros Auxilios', 'Suplementos'];
        return view('dashboard.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualizar un producto específico
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'categoria' => 'required',
            'descripcion' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // ✅ Actualización de imagen centralizada
        if ($request->hasFile('imagen')) {
            $imageService = new ImageUploadService();
            $imageService->deleteIfExists($producto->imagen ?? null);
            $data['imagen'] = $imageService->upload($request->file('imagen'), 'imagesProductos');
        }

        $producto->update($data);

        return redirect()->route('dashboard.productos')
                         ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Eliminar un producto específico
     */
    public function destroy(Producto $producto)
    {
        // ✅ Eliminación de imagen centralizada
        $imageService = new ImageUploadService();
        $imageService->deleteIfExists($producto->imagen ?? null);

        $producto->delete();

        return redirect()->route('dashboard.productos')
                         ->with('success', 'Producto eliminado exitosamente');
    }
}
