<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Oferta::with('trabajador')->latest();
        
        // Filtrar por búsqueda
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('titulo', 'like', "%{$search}%");
        }
        
        $ofertas = $query->get();
        return view('dashboard.ofertas.index', compact('ofertas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.ofertas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        // Asignar el trabajador autenticado
        $data['trabajador_id'] = auth()->guard('trabajador')->user()->id;
        
        // Manejar la carga de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::slug($request->titulo) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagesPromociones'), $nombreImagen);
            $data['imagen'] = 'imagesPromociones/' . $nombreImagen;
        }

        Oferta::create($data);

        return redirect()->route('dashboard.ofertas')
                         ->with('success', 'Oferta creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Oferta $oferta)
    {
        $oferta->load('trabajador');
        return view('dashboard.ofertas.show', compact('oferta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oferta $oferta)
    {
        return view('dashboard.ofertas.edit', compact('oferta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Oferta $oferta)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Manejar la carga de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($oferta->imagen && file_exists(public_path($oferta->imagen))) {
                unlink(public_path($oferta->imagen));
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::slug($request->titulo) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('imagesPromociones'), $nombreImagen);
            $data['imagen'] = 'imagesPromociones/' . $nombreImagen;
        }

        $oferta->update($data);

        return redirect()->route('dashboard.ofertas')
                         ->with('success', 'Oferta actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Oferta $oferta)
    {
        // Eliminar imagen si existe
        if ($oferta->imagen && file_exists(public_path($oferta->imagen))) {
            unlink(public_path($oferta->imagen));
        }
        
        $oferta->delete();

        return redirect()->route('dashboard.ofertas')
                         ->with('success', 'Oferta eliminada exitosamente');
    }
}
