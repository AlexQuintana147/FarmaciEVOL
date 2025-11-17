<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Mostrar la lista de productos
     */
    public function index(Request $request)
    {
       $query = Producto::query();

        // 2. Aplicar los filtros condicionales
        $query->when($request->search, function ($query, $search) {
            return $query
                ->where('titulo', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
        })
        ->when($request->categoria && $request->categoria !== 'todos', function ($query) use ($request) {
            return $query->where('categoria', $request->categoria);
        });

        // 3. Obtener el término de búsqueda para pasarlo a la vista
        $search = $request->search;
        
        // 4. Ejecutar la consulta con paginación
        $productos = $query->paginate(10);
        
        // 5. Retornar la vista
        return view('dashboard.productos.index', compact('productos', 'search'));
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

        $data = $request->only([ 'titulo', 'categoria', 'descripcion', 'imagen']);
        // Asignar el trabajador autenticado
        $data['trabajador_id'] = auth()->guard('trabajador')->user()->id;
        // Manejar la carga de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::slug($request->titulo) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagesProductos'), $nombreImagen);
            $data['imagen'] = 'imagesProductos/' . $nombreImagen;
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
        
        // Manejar la carga de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && file_exists(public_path($producto->imagen))) {
                unlink(public_path($producto->imagen));
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::slug($request->titulo) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagesProductos'), $nombreImagen);
            $data['imagen'] = 'imagesProductos/' . $nombreImagen;
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
        // Eliminar imagen si existe
        if ($producto->imagen && file_exists(public_path($producto->imagen))) {
            unlink(public_path($producto->imagen));
        }
        
        $producto->delete();

        return redirect()->route('dashboard.productos')
                         ->with('success', 'Producto eliminado exitosamente');
    }

}