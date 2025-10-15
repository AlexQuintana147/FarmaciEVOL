<?php

namespace App\Http\Controllers;

use App\Exports\AutogeneradorExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AutogeneradorLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AutogeneradorExportController extends Controller
{
    public function export(Request $request)
    {
        $query = AutogeneradorLog::with('trabajador')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros si existen
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $logs = $query->get();

        // Preparar métricas para el reporte
        $metrics = [
            'total_logs' => $logs->count(),
            'logs_por_trabajador' => $logs->groupBy('trabajador.usuario')
                ->map(function ($items) {
                    return $items->count();
                })
                ->toArray(),
            'fecha_reporte' => now()->format('Y-m-d H:i:s')
        ];

        $nombreArchivo = 'registros-autogenerador-' . now()->format('Y-m-d-His') . '.xlsx';
        
        return Excel::download(new AutogeneradorExportExcel($logs, $metrics), $nombreArchivo);
    }
}