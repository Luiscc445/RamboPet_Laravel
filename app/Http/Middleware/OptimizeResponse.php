<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     * Optimizaciones SUPER AGRESIVAS de respuesta HTTP
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo para respuestas HTML
        if ($response instanceof Response && str_contains($response->headers->get('Content-Type', ''), 'text/html')) {

            // 1. Comprimir respuesta AGRESIVAMENTE
            if (!$response->headers->has('Content-Encoding')) {
                $content = $response->getContent();

                // Minificar HTML en producción
                if (config('app.env') !== 'local') {
                    $content = $this->minifyHtmlAggressive($content);
                }

                $response->setContent($content);
            }

            // 2. Headers de cache MUY agresivo (6 horas en producción)
            $maxAge = config('app.env') === 'production' ? 21600 : 3600;
            $response->headers->set('Cache-Control', "public, max-age={$maxAge}, immutable");
            $response->headers->set('X-Accel-Buffering', 'no'); // Nginx buffering

            // 3. Preload y prefetch de recursos críticos
            $response->headers->set('Link', '</css/filament/filament/app.css>; rel=preload; as=style, </js/filament/filament/app.js>; rel=preload; as=script');
        }

        // 4. JSON responses - comprimir también
        if ($response instanceof Response && str_contains($response->headers->get('Content-Type', ''), 'application/json')) {
            // Cache corto para JSON (5 minutos)
            $response->headers->set('Cache-Control', 'public, max-age=300, must-revalidate');
        }

        // Headers de seguridad y performance
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Header para HTTP/2 Server Push (si está disponible)
        if ($request->secure() && config('app.env') === 'production') {
            $response->headers->set('X-HTTP-Push', 'true');
        }

        return $response;
    }

    /**
     * Minificar HTML AGRESIVAMENTE
     */
    private function minifyHtmlAggressive(string $html): string
    {
        // 1. Eliminar TODOS los comentarios HTML (incluyendo IE conditionals)
        $html = preg_replace('/<!--(?!\[if\s)(.|\s)*?-->/', '', $html);

        // 2. Eliminar espacios en blanco TOTALMENTE entre tags
        $html = preg_replace('/>\s+</', '><', $html);

        // 3. Eliminar espacios múltiples
        $html = preg_replace('/\s+/', ' ', $html);

        // 4. Eliminar espacios alrededor de = en atributos
        $html = preg_replace('/\s*=\s*/', '=', $html);

        // 5. Eliminar saltos de línea y tabs
        $html = str_replace(["\r\n", "\r", "\n", "\t"], '', $html);

        // 6. Eliminar espacios después de < y antes de >
        $html = preg_replace('/\s*<\s*/', '<', $html);
        $html = preg_replace('/\s*>\s*/', '>', $html);

        return trim($html);
    }
}
