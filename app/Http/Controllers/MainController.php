<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Inscrire;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use PHPUnit\Framework\Constraint\Count;

class MainController extends Controller
{
    /**
     * Retourne la page d'accueil
     */
    public function home()
    {
        // Récuération du hackathon actif (celui en cours)
        $equipe = SessionHelpers::getConnected();
        $hackathon = Hackathon::getActiveHackathon();
        $inscrit = Inscrire::getallinscription();
        $equipehack = Equipe::getEquipesInHackhon($hackathon->idhackathon);
        $nbplace = $equipehack->count();

        // Affichage de la vue, avec les données récupérées
        return view('main.home', [
            'hackathon' => $hackathon,
            'organisateur' => $hackathon->organisateur,
            'nbplace' => $nbplace,
            'equipeinscrit'=>$equipehack,
            'connected'=>$equipe,
            
        ]);
    }

    public function home_id($id)
    {
        // Récuération du hackathon actif (celui en cours)
        $equipe = SessionHelpers::getConnected();
        $hackathon = Hackathon::find($id);
        $inscrit = Inscrire::getallinscription();
        $equipehack = Equipe::getEquipesInHackhon($hackathon->idhackathon);
        $nbplace = $equipehack->count();

        // Affichage de la vue, avec les données récupérées
        return view('main.home', [
            'hackathon' => $hackathon,
            'organisateur' => $hackathon->organisateur,
            'nbplace' => $nbplace,
            'equipeinscrit'=>$equipehack,
            'connected'=>$equipe,
            
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
