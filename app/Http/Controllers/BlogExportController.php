<?php

namespace App\Http\Controllers;

use App\Exports\BlogExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Blog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlogExportController extends Controller
{
    public function export(Request $request)
    {
        $query = Blog::with('trabajador')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros si existen
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('subtitulo', 'like', "%{$search}%")
                  ->orWhere('contenido', 'like', "%{$search}%");
            });
        }

        $blogs = $query->get();

        // Preparar métricas para el reporte
        $metrics = [
            'total_blogs' => $blogs->count(),
            'blogs_por_autor' => $blogs->groupBy('trabajador.nombre_completo')
                ->map(function ($items) {
                    return $items->count();
                })
                ->toArray(),
            'fecha_reporte' => now()->format('Y-m-d H:i:s')
        ];

        $nombreArchivo = 'catalogo-blogs-' . now()->format('Y-m-d-His') . '.xlsx';
        
        return Excel::download(new BlogExportExcel($blogs, $metrics), $nombreArchivo);
    }
}