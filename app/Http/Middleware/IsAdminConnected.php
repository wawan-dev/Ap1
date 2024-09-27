<?php

namespace App\Http\Middleware;

use App\Utils\SessionHelpers;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminConnected
{

    public function handle(Request $request, Closure $next): Response
    {
        // Si l'équipe n'est pas connectée, on la redirige vers la page de connexion
        if (!SessionHelpers::isConnectedAdmin()) {
            return redirect("/loginAdmin");
        }

        return $next($request);
    }
}
