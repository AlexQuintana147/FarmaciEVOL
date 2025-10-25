<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AutogeneradorLog;

class ProductoDescripcionGeneradorController extends Controller
{
    protected $apiKey;
    protected $apiUrl;
    protected $model;
    protected $catalogPath;

    public function __construct()
    {
        $this->apiKey = env('AI_API_KEY');
        $this->apiUrl = env('AI_API_URL');
        $this->model = env('AI_MODEL');
        $this->catalogPath = public_path('catalogo.txt');
    }

    public function generar(Request $request) {
        try {
            $request->validate([
                'message' => 'required|string|max:255'
            ]);

            $userMessage = trim($request->input('message'));
            
            if (!file_exists($this->catalogPath)) {
                throw new \Exception('No se encontró el archivo de catálogo');
            }

            $catalogContent = file_get_contents($this->catalogPath);
            if ($catalogContent === false) {
                throw new \Exception('No se pudo leer el archivo de catálogo');
            }

            $systemMessage = "Proporciona una descripción clara y concisa del siguiente producto médico basándote en el catálogo. Si el producto no está en el catálogo, indícalo.\n\nCatálogo:\n" . $catalogContent;

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => config('app.url'),
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemMessage],
                    ['role' => 'user', 'content' => $userMessage]
                ]
            ]);

            $responseData = $response->json();

            if (!isset($responseData['choices'][0]['message']['content'])) {
                throw new \Exception('La respuesta de la API no tiene el formato esperado');
            }

            $content = trim($responseData['choices'][0]['message']['content']);
            
            // Limpiar y formatear la respuesta
            $content = strip_tags($content);
            $content = str_replace(["\"", "\n"], ['"', ' '], $content);
            $content = preg_replace('/\s+/', ' ', $content);
            
            // Guardar el registro de autogeneración si el usuario está autenticado
            if (auth()->guard('trabajador')->check()) {
                AutogeneradorLog::create([
                    'trabajador_id' => auth()->guard('trabajador')->id(),
                    'titulo' => $userMessage,
                    'descripcion' => $content
                ]);
            }
            
            // Asegurarse de devolver una respuesta JSON válida
            return response()->json([
                'success' => true,
                'message' => $content
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos: ' . $e->getMessage()
            ], 400);
            
        } catch (\Exception $e) {
            Log::error('Error en ProductoDescripcionGeneradorController: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar la descripción: ' . $e->getMessage()
            ], 500);
        }
    }
}
