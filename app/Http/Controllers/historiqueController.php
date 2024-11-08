<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Inscrire;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use App\Http\Controllers\Controller;

class historiqueController extends Controller
{
    public function Listerhackaton(){
        $equipe = SessionHelpers::getConnected();
        $hackathon = Hackathon::orderBy('dateheuredebuth', 'asc')->paginate(4);
        return view('historique',['hackathon' => $hackathon, 'connected'=>$equipe]);
    }

    public function filtrer_n(Request $request)
    {
        $equipe = SessionHelpers::getConnected();
        if($equipe != null){
            $inscription = Inscrire::getinscription($equipe->idequipe);
        }
        
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

        if ($request->has('participer')) {
            
            $idhackathon = $inscription->whereNull('datedesinscription')->pluck('idhackathon')->toArray();
            $query->whereIn('idhackathon', $idhackathon);
        }

        $hackathon = $query->paginate(5); // Pagination

        return view('historique',['hackathon' => $hackathon, 'connected'=>$equipe]);
    }

}
