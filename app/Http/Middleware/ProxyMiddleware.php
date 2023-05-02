<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProxyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'URL de la ressource est fournie en paramètre de la requête
        if ($request->has('url')) {
            // Appelle la méthode 'proxy' du contrôleur 'ProxyController'
            return app()->call('App\Http\Controllers\ProxyController@proxy', ['request' => $request]);
        }

        // Continue le traitement de la requête
        return $next($request);
    }
}
