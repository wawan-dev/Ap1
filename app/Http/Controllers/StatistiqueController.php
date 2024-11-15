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
    public function statistique(Request $request){

            // Si aucune année n'est précisée, utilisez l'année en cours par défaut
        $year = $request->get('year', now()->year); 

        // Obtenez tous les mois de l'année, même ceux avec 0 hackathons
        $months = collect(range(1, 12)); // Crée un tableau de 1 à 12 pour les mois
        $monthHackathons = DB::table('HACKATHON')
            ->select(DB::raw('MONTH(dateheuredebuth) as month, COUNT(*) as count'))
            ->whereYear('dateheuredebuth', $year) // Filtre par l'année
            ->groupBy('month')
            ->get()
            ->keyBy('month'); // Transforme le résultat en un tableau associatif avec le mois comme clé

        // Préparez les données pour chaque mois
        $hackathonsByMonth = $months->mapWithKeys(function ($month) use ($monthHackathons) {
            return [$month => $monthHackathons->get($month, (object)['count' => 0])];
        });

        // Récupérer les années disponibles dans la base pour remplir le champ de sélection
        $years = DB::table('HACKATHON')
            ->select(DB::raw('DISTINCT YEAR(dateheuredebuth) as year'))
            ->orderBy('year', 'desc')
            ->pluck('year');

        $visits = DB::table('LOGS')
            ->selectRaw('DATE(created_at) as day, COUNT(*) as visits')
            ->where('description', 'like', '%Connection%')
            ->where('created_at', '>=', Carbon::now()->subDays(5))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('day', 'desc')
            ->get();

        $nbequipe = Equipe::all()->count();
        $nbmembre = Membre::all()->count();


        return view('statistique', [
            'hackathonsByMonth' => $hackathonsByMonth,
            'years' => $years,
            'selectedYear' => $year,
            'visits' => $visits,
            'nbequipe' => $nbequipe,
            'nbmembre' => $nbmembre,
        ]);
    }

    public function statistique_hack(Request $request){

        
    }

}
