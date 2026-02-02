<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedMiddleware
{
    /**
     * Verifica que el usuario tenga el email verificado
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('warning', 'Debes verificar tu email antes de continuar.');
        }

        return $next($request);
    }
}