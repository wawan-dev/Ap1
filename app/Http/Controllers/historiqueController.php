<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;

class historiqueController extends Controller
{
    public function Listerhackaton(){
        
        $hackathon = Hackathon::paginate(5);
        return view('historique',['hackathon' => $hackathon]);
    }

    public function filtrer_n(Request $request)
    {
        $query = Hackathon::query();

        if ($search = $request->get('search')) {
            $query->where('thematique', 'like', '%' . $search . '%');
        }

        $hackathon = $query->paginate(5); // Pagination

        return view('historique',['hackathon' => $hackathon]);
    }

}
