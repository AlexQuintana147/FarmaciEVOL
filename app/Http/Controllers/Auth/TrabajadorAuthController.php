<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TrabajadorAuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */ 
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Manejar el intento de login
     */
    public function login(Request $request)
    {
        $lockoutKey = 'login_attempts_' . $request->ip();
        $lockoutTimeKey = 'lockout_time_' . $request->ip();
        
        $attempts = $request->session()->get($lockoutKey, 0);
        $lockoutTime = $request->session()->get($lockoutTimeKey);
        
        if ($lockoutTime && now()->timestamp < $lockoutTime) {
            $remainingTime = $lockoutTime - now()->timestamp;
            throw ValidationException::withMessages([
                'usuario' => "Demasiados intentos fallidos. Intenta nuevamente en {$remainingTime} segundos.",
            ]);
        }
        
        if ($lockoutTime && now()->timestamp >= $lockoutTime) {
            $request->session()->forget([$lockoutKey, $lockoutTimeKey]);
            $attempts = 0;
        }

        $credentials = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('trabajador')->attempt($credentials, $request->filled('remember'))) {
            // Login exitoso - limpiar intentos fallidos
            $request->session()->forget([$lockoutKey, $lockoutTimeKey]);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Login fallido - incrementar contador de intentos
        $attempts++;
        $request->session()->put($lockoutKey, $attempts);
        
        // Si alcanza 3 intentos, bloquear por 1 minuto
        if ($attempts >= 3) {
            $lockoutUntil = now()->addMinute()->timestamp;
            $request->session()->put($lockoutTimeKey, $lockoutUntil);
            
            throw ValidationException::withMessages([
                'usuario' => 'Demasiados intentos fallidos. Tu cuenta ha sido bloqueada por 1 minuto.',
            ]);
        }
        
        $remainingAttempts = 3 - $attempts;
        throw ValidationException::withMessages([
            'usuario' => "Credenciales incorrectas. Te quedan {$remainingAttempts} intentos.",
        ]);
    }

    /**
     * Cerrar sesión del usuario
     */
    public function logout(Request $request)
    {
        Auth::guard('trabajador')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}