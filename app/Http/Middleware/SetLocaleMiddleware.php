<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->headers->has('X-App-Locale')
            && in_array($request->headers->get('X-App-Locale'), config('app.locales'))
        ) {
            \App::setLocale($request->headers->get('X-App-Locale'));
        }
        \App::setLocale('ro');
        return $next($request);
    }
}
