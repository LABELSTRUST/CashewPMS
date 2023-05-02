<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProxyController extends Controller
{
    public function proxy(Request $request)
    {
        // Récupère l'URL de la ressource à récupérer à partir des paramètres de requête
        $url = $request->input('url');

        // Effectue une requête HTTP vers l'URL de la ressource à l'aide de GuzzleHttp\Client
        $client = new Client();
        $response = $client->get($url);

        // Retourne la réponse de la ressource au client
        return response($response->getBody(), $response->getStatusCode())
            ->header('Content-Type', $response->getHeaderLine('Content-Type'));
    }
}
    

