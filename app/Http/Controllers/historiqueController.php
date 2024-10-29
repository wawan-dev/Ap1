<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use App\Http\Controllers\Controller;

class historiqueController extends Controller
{
    public function Listerhackaton(){
        
        $hackathon = Hackathon::orderBy('dateheuredebuth', 'asc')->paginate(4);
        return view('historique',['hackathon' => $hackathon]);
    }

    public function filtrer_n(Request $request)
    {
        $equipe = SessionHelpers::getConnected();
        $query = Hackathon::query();
        $currentDate = now();

        if ($search = $request->get('search')) {
            $query->where('thematique', 'like', '%' . $search . '%');
        }

        if ($status = $request->get('status')) {
            if ($status == 'a_venir') {
                $query->where('dateheuredebuth', '>', $currentDate);
            } elseif ($status == 'en_cours') {
                $query->where('dateheuredebuth', '<=', $currentDate)
                      ->where('dateheurefinh', '>=', $currentDate);
            } elseif ($status == 'passe') {
                $query->where('dateheurefinh', '<', $currentDate);
            }
        }

        $hackathon = $query->paginate(5); // Pagination

        return view('historique',['hackathon' => $hackathon]);
    }

}
