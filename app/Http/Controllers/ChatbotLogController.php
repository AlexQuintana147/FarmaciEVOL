<?php

namespace App\Http\Controllers;

use App\Models\ChatbotLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotLogController extends Controller
{
    /**
     * Almacena un nuevo registro de interacción con el chatbot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pregunta' => 'required|string',
            'respuesta' => 'required|string',
        ]);

        $trabajadorId = Auth::check() ? Auth::user()->trabajador->id : null;

        $log = ChatbotLog::create([
            'trabajador_id' => $trabajadorId,
            'pregunta' => $request->pregunta,
            'respuesta' => $request->respuesta,
            'es_autenticado' => Auth::check(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $log
        ], 201);
    }

    /**
     * Obtiene el historial de interacciones del chatbot
     * Si el usuario es administrador, obtiene todo el historial
     * Si es un trabajador, solo obtiene sus propias interacciones
     * Si no está autenticado, retorna vacío
     *
     * @return \Illuminate\Http\Response
     */
    public function historial()
    {
        if (Auth::check()) {
            // Check if user is admin by email or other identifier if role system is not available
            $isAdmin = in_array(Auth::user()->email, ['admin@example.com']); // Add admin emails here
            
            if ($isAdmin) {
                $historial = ChatbotLog::with('trabajador')->latest()->get();
            } else {
                // Only show logs for the authenticated worker
                $historial = ChatbotLog::where('trabajador_id', Auth::user()->trabajador->id)
                    ->latest()
                    ->get();
            }
        } else {
            $historial = [];
        }

        return response()->json([
            'success' => true,
            'data' => $historial
        ]);
    }

    /**
     * Muestra las métricas del chatbot
     *
     * @return \Illuminate\View\View
     */
    public function metrics()
    {
        // Obtener estadísticas generales
        $totalInteracciones = ChatbotLog::count();
        $interaccionesHoy = ChatbotLog::whereDate('created_at', today())->count();
        $preguntasUnicas = ChatbotLog::distinct('pregunta')->count();
        
        // Obtener interacciones por tipo de usuario
        $interaccionesAutenticadas = ChatbotLog::where('es_autenticado', true)->count();
        $interaccionesNoAutenticadas = $totalInteracciones - $interaccionesAutenticadas;
        
        // Obtener los logs para la tabla
        $chatbotLogs = ChatbotLog::with('trabajador')
            ->latest()
            ->paginate(10);

        return view('dashboard.chatbot-metrics', [
            'totalInteracciones' => $totalInteracciones,
            'interaccionesHoy' => $interaccionesHoy,
            'preguntasUnicas' => $preguntasUnicas,
            'interaccionesAutenticadas' => $interaccionesAutenticadas,
            'interaccionesNoAutenticadas' => $interaccionesNoAutenticadas,
            'chatbotLogs' => $chatbotLogs
        ]);
    }
}
