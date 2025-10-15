<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AutogeneradorLog;

class AutogeneradorLogController extends Controller
{
    /**
     * Mostrar la lista de logs de autogeneración
     */
    public function index()
    {
        $logs = AutogeneradorLog::with('trabajador')
                               ->latest()
                               ->paginate(10);
        
        return view('dashboard.autogenerador.index', compact('logs'));
    }

    /**
     * Mostrar un log específico
     */
    public function show(AutogeneradorLog $log)
    {
        return view('dashboard.autogenerador.show', compact('log'));
    }
}