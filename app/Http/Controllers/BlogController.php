<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ImageUploadService;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('trabajador')->latest()->get();
        return view('dashboard.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'subtitulo' => 'required|max:255',
            'contenido' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog = new Blog();
        $blog->trabajador_id = auth()->guard('trabajador')->user()->id;
        $blog->titulo = $request->titulo;
        $blog->subtitulo = $request->subtitulo;
        $blog->contenido = $request->contenido;

        // ✅ Subida de imagen centralizada
        if ($request->hasFile('imagen')) {
            $imageService = new ImageUploadService();
            $blog->imagen = $imageService->upload($request->file('imagen'), 'imagesBlog');
        }

        $blog->save();

        return redirect()->route('dashboard.blogs')
            ->with('success', 'Blog creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('dashboard.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('dashboard.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'subtitulo' => 'required|max:255',
            'contenido' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog->titulo = $request->titulo;
        $blog->subtitulo = $request->subtitulo;
        $blog->contenido = $request->contenido;

        // ✅ Actualización de imagen centralizada
        if ($request->hasFile('imagen')) {
            $imageService = new ImageUploadService();
            $imageService->deleteIfExists($blog->imagen ?? null);
            $blog->imagen = $imageService->upload($request->file('imagen'), 'imagesBlog');
        }

        $blog->save();

        return redirect()->route('dashboard.blogs')
            ->with('success', 'Blog actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // ✅ Eliminación de imagen centralizada
        $imageService = new ImageUploadService();
        $imageService->deleteIfExists($blog->imagen ?? null);

        $blog->delete();

        return redirect()->route('dashboard.blogs')
            ->with('success', 'Blog eliminado correctamente.');
    }
}
