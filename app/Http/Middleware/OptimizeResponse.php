<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     * Optimizaciones de respuesta HTTP
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo para respuestas HTML
        if ($response instanceof Response && str_contains($response->headers->get('Content-Type', ''), 'text/html')) {

            // 1. Comprimir respuesta
            if (!$response->headers->has('Content-Encoding')) {
                $content = $response->getContent();

                // Minificar HTML
                if (!app()->isLocal()) {
                    $content = $this->minifyHtml($content);
                }

                $response->setContent($content);
            }

            // 2. Headers de cache agresivo
            $response->headers->set('Cache-Control', 'public, max-age=3600, must-revalidate');
            $response->headers->set('X-Accel-Buffering', 'no'); // Nginx buffering

            // 3. Preload de recursos críticos
            $response->headers->set('Link', '</css/app.css>; rel=preload; as=style');
        }

        // Headers de performance
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }

    /**
     * Minificar HTML simple
     */
    private function minifyHtml(string $html): string
    {
        // Eliminar comentarios HTML
        $html = preg_replace('/<!--(.|\s)*?-->/', '', $html);

        // Eliminar espacios en blanco múltiples
        $html = preg_replace('/\s+/', ' ', $html);

        // Eliminar espacios entre tags
        $html = preg_replace('/>\s+</', '><', $html);

        return trim($html);
    }
}
