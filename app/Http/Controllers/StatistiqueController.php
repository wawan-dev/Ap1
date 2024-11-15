<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function statistique(Request $request){

        $year = $request->get('year'); // Année sélectionnée

        $query = DB::table('HACKATHON')
            ->select(DB::raw('MONTH(dateheuredebuth) as month, YEAR(dateheuredebuth) as year, COUNT(*) as count'))
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

        // Filtrer par année si une année est spécifiée
        if ($year) {
            $query->whereYear('dateheuredebuth', $year);
        }

        $hackathons = $query->get();

        // Récupérer les années disponibles dans la base pour remplir le champ de sélection
        $years = DB::table('HACKATHON')
            ->select(DB::raw('DISTINCT YEAR(dateheuredebuth) as year'))
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('statistique', [
            'hackathons' => $hackathons,
            'years' => $years,
            'selectedYear' => $year,
        ]);
    }
}
