<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class MainController extends Controller
{
    /**
     * Retourne la page d'accueil
     */
    public function home()
    {
        // Récuération du hackathon actif (celui en cours)
        
        $hackathon = Hackathon::getActiveHackathon();

        $equipehack = Equipe::getEquipesInHackhon($hackathon->idhackathon);
        $nbplace = $equipehack->count();

        // Affichage de la vue, avec les données récupérées
        return view('main.home', [
            'hackathon' => $hackathon,
            'organisateur' => $hackathon->organisateur,
            'nbplace' => $nbplace,
        ]);
    }

    /**
     * Retourne la page "À propos"
     */
    public function about()
    {
        return view('main.about');
    }
}
