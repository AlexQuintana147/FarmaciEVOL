<?php

namespace App\Http\Controllers;

use App\Exports\ProductoMetricsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductoExportController extends Controller
{
    public function export(Request $request)
    {
        $query = Producto::with('trabajador')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros si existen
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('categoria', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('categoria') && $request->categoria) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->get();

        // Preparar métricas para el reporte
        $metrics = [
            'total_productos' => $productos->count(),
            'productos_por_categoria' => $productos->groupBy('categoria')
                ->map(function ($items) {
                    return $items->count();
                })
                ->toArray(),
            'fecha_reporte' => now()->format('Y-m-d H:i:s')
        ];

        $nombreArchivo = 'catalogo-productos-' . now()->format('Y-m-d-His') . '.xlsx';
        
        return Excel::download(new ProductoMetricsExport($productos, $metrics), $nombreArchivo);
    }
}