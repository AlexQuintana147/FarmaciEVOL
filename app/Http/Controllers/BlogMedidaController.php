<?php

namespace App\Http\Controllers;

use App\Models\BlogMedida;
use App\Models\Trabajador;
use App\Exports\BlogMetricsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BlogMedidaController extends Controller
{
    protected $apiKey;
    protected $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected $model = 'deepseek/deepseek-chat:free';

    public function __construct()
    {
        $this->middleware('auth');
        $this->apiKey = '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';
    }
    
    /**
     * Evaluate content quality via AJAX
     */
    public function evaluateContent(Request $request)
    {
        try {
            // Validate request with minimum length
            $validated = $request->validate([
                'titulo' => 'required|string|min:3|max:255',
                'contenido' => 'required|string|min:3',
            ], [
                'titulo.min' => 'El título debe tener al menos 3 caracteres.',
                'contenido.min' => 'El contenido debe tener al menos 3 caracteres.'
            ]);
            
            // Check if API key is set
            if (empty($this->apiKey)) {
                throw new \Exception('La configuración de la API no está completa.');
            }
            
            // Simple prompt for percentage and recommendation
            $prompt = "Analiza el siguiente título y contenido de blog y devuelve SOLO un número del 1 al 100 que represente la calidad del contenido.\n\n"
                   . "Título: " . $validated['titulo'] . "\n\n"
                   . "Contenido: " . $validated['contenido'];
            
            // Make API call to OpenRouter
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un analizador de contenido. Solo responde con un número del 1 al 100.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.3,
                'max_tokens' => 10
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $content = trim($result['choices'][0]['message']['content'] ?? '');
                
                // Extract number from response
                preg_match('/\d+/', $content, $matches);
                $score = isset($matches[0]) ? (int)$matches[0] : 50;
                $score = max(1, min(100, $score));
                
                // Simple recommendation based on score
                $recommendation = $this->getRecommendation($score);
                $scoreClass = $this->getScoreClass($score);
                
                // Save to barra_de_blogs table
                $blogMedida = new BlogMedida();
                $blogMedida->trabajador_id = auth('trabajador')->id();
                $blogMedida->titulo = $validated['titulo'];
                $blogMedida->contenido = $validated['contenido'];
                $blogMedida->valoracion = $score;
                $blogMedida->recomendacion = $recommendation;
                $blogMedida->save();
                
                return response()->json([
                    'success' => true,
                    'puntuacion' => $score,
                    'message' => $recommendation,
                    'class' => $scoreClass,
                    'fecha' => now()->format('d/m/Y H:i:s')
                ]);
            }
            
            throw new \Exception('Error al conectar con el servicio de análisis');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error', ['error' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error en BlogMedidaController', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'debug' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => config('app.debug') ? $e->getTraceAsString() : null
                ] : null
            ], 500);
        }
    }
    
    /**
     * Get a message based on similarity score
     */
    protected function getSimilarityMessage($score)
    {
        if ($score < 30) {
            return 'Contenido altamente original. ¡Excelente trabajo!';
        } elseif ($score < 70) {
            return 'Contenido con cierta similitud a otros. Considera hacerlo más único.';
        } else {
            return 'Contenido con alta similitud a otros. Se recomienda revisar y modificar.';
        }
    }
    
    /**
     * Get CSS class based on similarity score
     */
    protected function getSimilarityClass($score)
    {
        if ($score < 30) {
            return 'text-success';
        } elseif ($score < 70) {
            return 'text-warning';
        } else {
            return 'text-danger';
        }
    }
    
    /**
     * Get CSS class based on score
     */
    public function getScoreClass($score)
    {
        if ($score >= 70) return 'success';
        if ($score >= 40) return 'warning';
        return 'danger';
    }
    
    /**
     * Display blog metrics
     */
    public function metrics()
    {
        // Get distribution of ratings
        $distribution = [0, 0, 0, 0, 0]; // 0-19, 20-39, 40-59, 60-79, 80-100
        $valoraciones = BlogMedida::pluck('valoracion');
        
        foreach ($valoraciones as $valoracion) {
            if ($valoracion < 20) $distribution[0]++;
            elseif ($valoracion < 40) $distribution[1]++;
            elseif ($valoracion < 60) $distribution[2]++;
            elseif ($valoracion < 80) $distribution[3]++;
            else $distribution[4]++;
        }
        
        $mediciones_recientes = BlogMedida::with('trabajador')
            ->latest()
            ->take(10)
            ->get();
            
        $metrics = [
            'total_mediciones' => BlogMedida::count(),
            'promedio_valoracion' => round(BlogMedida::avg('valoracion') ?? 0, 1),
            'mejor_valoracion' => BlogMedida::max('valoracion') ?? 0,
            'peor_valoracion' => BlogMedida::min('valoracion') ?? 0,
            'distribucion_valoraciones' => $distribution,
            'mediciones_por_trabajador' => BlogMedida::with('trabajador')
                ->selectRaw('trabajador_id, COUNT(*) as total')
                ->groupBy('trabajador_id')
                ->orderBy('total', 'desc')
                ->get(),
            'mediciones_recientes' => $mediciones_recientes
        ];
        
        if (request()->has('export')) {
            return Excel::download(
                new BlogMetricsExport($metrics, $mediciones_recientes), 
                'metricas-blogs-' . now()->format('Y-m-d') . '.xlsx'
            );
        }
        
        return view('dashboard.blog-metrics', compact('metrics'));
    }
    
    protected function getRecommendation($score)
    {
        if ($score >= 90) {
            return 'Excelente contenido. Muy bien optimizado y relevante.';
        } elseif ($score >= 70) {
            return 'Buen contenido. Podrías mejorar algunos aspectos para una mejor puntuación.';
        } elseif ($score >= 50) {
            return 'Contenido regular. Considera revisar y mejorar varios aspectos.';
        } else {
            return 'El contenido necesita mejoras significativas para ser efectivo.';
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medidas = BlogMedida::all();
        return view('dashboard.blog_medidas.index', compact('medidas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.blog_medidas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido' => 'required|string',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'id_blog' => 'required|exists:blogs,id',
            'valoracion' => 'nullable|integer|min:0|max:100',
        ]);

        // Calcular puntuación de calidad
        $puntuacion = $this->evaluarCalidadContenido($request->titulo, $request->contenido);
        
        $data = $request->only(['titulo', 'descripcion', 'contenido', 'trabajador_id', 'id_blog', 'valoracion']);
        $data['puntuacion_calidad'] = $puntuacion;

        BlogMedida::create($data);

        return redirect()->route('blog-medidas.index')
            ->with('success', 'Medida creada exitosamente. Puntuación de calidad: ' . $puntuacion . '%');
    }
    
    /**
     * Evalúa la calidad del contenido basado en el título y contenido
     *
     * @param string $titulo
     * @param string $contenido
     * @return int Puntuación de 0 a 100
     */
    protected function evaluarCalidadContenido($titulo, $contenido)
    {
        try {
            $prompt = "Evalúa la calidad del siguiente contenido de blog basándote en su título y contenido. 
            Solo devuelve un número del 0 al 100 que represente el porcentaje de calidad.\n\n" .
            "Título: " . $titulo . "\n\n" .
            "Contenido: " . $contenido . "\n\n" .
            "Solo devuelve el número, sin texto adicional.";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.3,
                'max_tokens' => 5
            ]);

            $responseData = $response->json();
            $puntuacion = (int) trim($responseData['choices'][0]['message']['content'] ?? '0');
            
            // Asegurarse de que la puntuación esté entre 0 y 100
            return max(0, min(100, $puntuacion));
            
        } catch (\Exception $e) {
            Log::error('Error al evaluar la calidad del contenido: ' . $e->getMessage());
            return 0; // En caso de error, retornar 0
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogMedida $blogMedida)
    {
        return view('dashboard.blog_medidas.show', compact('blogMedida'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogMedida $blogMedida)
    {
        return view('dashboard.blog_medidas.edit', compact('blogMedida'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogMedida $blogMedida)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido' => 'required|string',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'id_blog' => 'required|exists:blogs,id',
            'valoracion' => 'nullable|integer|min:0|max:100',
        ]);

        // Recalcular puntuación de calidad si el título o contenido cambiaron
        if ($request->titulo !== $blogMedida->titulo || $request->contenido !== $blogMedida->contenido) {
            $puntuacion = $this->evaluarCalidadContenido($request->titulo, $request->contenido);
            $request->merge(['puntuacion_calidad' => $puntuacion]);
        }

        $blogMedida->update($request->only(['titulo', 'descripcion', 'contenido', 'trabajador_id', 'id_blog', 'valoracion', 'puntuacion_calidad']));

        return redirect()->route('blog-medidas.index')
            ->with('success', 'Medida actualizada exitosamente. ' . 
                (isset($puntuacion) ? "Nueva puntuación de calidad: {$puntuacion}%" : ''));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogMedida $blogMedida)
    {
        $blogMedida->delete();

        return redirect()->route('blog-medidas.index')
            ->with('success', 'Medida eliminada exitosamente');
    }
}
