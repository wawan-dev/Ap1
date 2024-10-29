<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Utils\SessionHelpers;

class CommentaireController extends Controller
{
    public function commenter(Request $request){
        $equipe = SessionHelpers::getConnected();
        $idh = $request->query('idh');
        $hackathon = Hackathon::find($idh);


        return view('commentaire', ["hackathon" => $hackathon, "equipe" => $equipe]);
    }

    public function ajouter_commenter (Request $request){
        
    }
    
}
