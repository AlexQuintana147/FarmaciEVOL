<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TrabajadorController extends Controller
{
    /**
     * Mostrar la lista de trabajadores
     */
    public function index()
    {
        $trabajadores = Trabajador::all();
        $isAdmin = Auth::guard('trabajador')->user()->usuario === 'admin';
        
        return view('dashboard.trabajadores.index', compact('trabajadores', 'isAdmin'));
    }

    /**
     * Mostrar el formulario para crear un nuevo trabajador
     */
    public function create()
    {
        // Verificar si el usuario es admin
        if (Auth::guard('trabajador')->user()->usuario !== 'admin') {
            return redirect()->route('trabajadores.index')
                ->with('error', 'No tienes permisos para crear trabajadores');
        }
        
        return view('dashboard.trabajadores.create');
    }

    /**
     * Almacenar un nuevo trabajador
     */
    public function store(Request $request)
    {
        // Verificar si el usuario es admin
        if (Auth::guard('trabajador')->user()->usuario !== 'admin') {
            return redirect()->route('dashboard.trabajadores')
                ->with('error', 'No tienes permisos para crear trabajadores');
        }
        
        $validated = $request->validate([
            'usuario' => 'required|string|max:255|unique:trabajadores',
            'password' => 'required|string|min:6',
            'nombre_completo' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:trabajadores',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        Trabajador::create($validated);
        
        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador creado correctamente');
    }

    /**
     * Mostrar un trabajador específico
     */
    public function show(Trabajador $trabajador)
    {
        return view('dashboard.trabajadores.show', compact('trabajador'));
    }
    
    /**
     * Mostrar el formulario para editar un trabajador
     */
    public function edit(Trabajador $trabajador)
    {
        // Verificar si el usuario es admin
        if (Auth::guard('trabajador')->user()->usuario !== 'admin') {
            return redirect()->route('trabajadores.index')
                ->with('error', 'No tienes permisos para editar trabajadores');
        }
        
        return view('dashboard.trabajadores.edit', compact('trabajador'));
    }
    
    /**
     * Actualizar un trabajador específico
     */
    public function update(Request $request, Trabajador $trabajador)
    {
        // Verificar si el usuario es admin
        if (Auth::guard('trabajador')->user()->usuario !== 'admin') {
            return redirect()->route('dashboard.trabajadores')
                ->with('error', 'No tienes permisos para editar trabajadores');
        }
        
        $rules = [
            'usuario' => 'required|string|max:255|unique:trabajadores,usuario,' . $trabajador->id,
            'nombre_completo' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:trabajadores,dni,' . $trabajador->id,
        ];
        
        // Solo validar password si se proporciona
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6';
        }
        
        $validated = $request->validate($rules);
        
        // Solo actualizar password si se proporciona
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $trabajador->update($validated);
        
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador ' . $trabajador->nombre . ' actualizado con éxito.');
    }
    
    /**
     * Eliminar un trabajador específico
     */
    public function destroy(Trabajador $trabajador)
    {
        // Verificar si el usuario es admin
        if (Auth::guard('trabajador')->user()->usuario !== 'admin') {
            return redirect()->route('trabajadores.index')
                ->with('error', 'No tienes permisos para eliminar trabajadores');
        }
        
        // Evitar que se elimine el usuario admin
        if ($trabajador->usuario === 'admin') {
            return redirect()->route('trabajadores.index')
                ->with('error', 'No se puede eliminar el usuario administrador');
        }
        
        $trabajador->delete();
        
        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador eliminado correctamente');
    }
}