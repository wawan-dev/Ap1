<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Membre;

class StatistiqueController extends Controller
{
    public function statistique(Request $request)
{
    // Année par défaut (l'année en cours)
    $year = $request->get('year', now()->year);

    // Filtrer par ville si une ville est précisée dans la requête
    $selectedVille = $request->get('ville');

    // Mois pour la vue (1 à 12)
    $months = collect(range(1, 12));

    // Hackathons par mois pour l'année donnée
    $monthHackathons = DB::table('HACKATHON')
        ->select(DB::raw('MONTH(dateheuredebuth) as month, COUNT(*) as count'))
        ->whereYear('dateheuredebuth', $year)
        ->groupBy('month')
        ->get()
        ->keyBy('month');

    $hackathonsByMonth = $months->mapWithKeys(function ($month) use ($monthHackathons) {
        return [$month => $monthHackathons->get($month, (object)['count' => 0])];
    });

    // Années disponibles
    $years = DB::table('HACKATHON')
        ->select(DB::raw('DISTINCT YEAR(dateheuredebuth) as year'))
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Nombre de hackathons par ville
    $hackathonsByVilleQuery = DB::table('HACKATHON')
        ->select(DB::raw('ville, COUNT(*) as count'))
        ->groupBy('ville')
        ->orderBy('count', 'desc');

    // Filtrer par ville si sélectionnée
    if ($selectedVille) {
        $hackathonsByVilleQuery->where('ville', $selectedVille);
    }

    $hackathonsByVille = $hackathonsByVilleQuery->get();

    // Visites des 5 derniers jours
    $visits = DB::table('LOGS')
        ->selectRaw('DATE(created_at) as day, COUNT(*) as visits')
        ->where('description', 'like', '%Connection%')
        ->where('created_at', '>=', now()->subDays(5))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('day', 'desc')
        ->get();

    // Statistiques globales
    $nbequipe = Equipe::count();
    $nbmembre = Membre::count();

    return view('statistique', [
        'hackathonsByMonth' => $hackathonsByMonth,
        'years' => $years,
        'selectedYear' => $year,
        'selectedVille' => $selectedVille,
        'hackathonsByVille' => $hackathonsByVille,
        'visits' => $visits,
        'nbequipe' => $nbequipe,
        'nbmembre' => $nbmembre,
    ]);
}

    public function statistique_hack(Request $request){
        $idh = $request->query('idh');
        $hackathon = Hackathon::find($idh);

        $equipehack = Equipe::getEquipesInHackhon($hackathon->idhackathon);
        $nb_equipedes = Equipe::getEquipesDesInHackhon($hackathon->idhackathon);
        $nb_equipedes = $nb_equipedes->count();

        $nb_equipe = $equipehack->count();
        
        $nb_membre = Membre::getMembreInHackhon($idh);

        return view('statistique_hack', ["hackathon" => $hackathon, "nb_equipe" => $nb_equipe, "nb_membre" => $nb_membre, "nb_equipedes" => $nb_equipedes]);
    }

}
