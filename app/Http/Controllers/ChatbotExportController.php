<?php

namespace App\Http\Controllers;

use App\Exports\ChatbotMetricsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ChatbotLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChatbotExportController extends Controller
{
    public function export(Request $request)
    {
        $query = ChatbotLog::with('trabajador')
            ->orderBy('created_at', 'desc');

        // Aplicar filtros si existen
        if ($request->has('fecha_inicio') && $request->fecha_inicio) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        
        if ($request->has('fecha_fin') && $request->fecha_fin) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }
        
        if ($request->has('tipo_usuario') && $request->tipo_usuario !== 'todos') {
            $query->where('es_autenticado', $request->tipo_usuario === 'autenticado');
        }

        $logs = $query->get([
            'id',
            'trabajador_id',
            'es_autenticado',
            'pregunta',
            'respuesta',
            'created_at',
            'updated_at'
        ]);

        // Resumen para el archivo Excel
        $summary = [
            'total_interacciones' => $logs->count(),
            'fecha_inicio' => $request->fecha_inicio ?? $logs->min('created_at'),
            'fecha_fin' => $request->fecha_fin ?? $logs->max('created_at'),
            'fecha_reporte' => now()->format('Y-m-d H:i:s')
        ];

        $nombreArchivo = 'reporte-chatbot-' . now()->format('Y-m-d-His') . '.xlsx';
        
        return Excel::download(new ChatbotMetricsExport($logs, $summary), $nombreArchivo);
    }
}
