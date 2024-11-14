<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Inscrire;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CommentaireController extends Controller
{
    public function commenter(Request $request){
        $equipe = SessionHelpers::getConnected();
        $idh = $request->query('idh');
        $hackathon = Hackathon::find($idh);
        $commentaires = Inscrire::with('equipe')->where('idhackathon', $idh)->get();


        return view('commentaire', ["hackathon" => $hackathon, "equipe" => $equipe, "commentaires" => $commentaires]);
    }

    public function ajouter_commenter (Request $request){
        $request->validate(
            [
                'commentaire' => 'required|string|max:500',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
            ],
            [
                'commentaire' => 'commentaire',
            ]
        );
        $hackathon = Hackathon::find($request->idhackathon);
        $equipe = SessionHelpers::getConnected();
        $commentaires = Inscrire::with('equipe')->where('idhackathon', $request->idhackathon)->get();
        
        $inscription = DB::table('INSCRIRE')
            ->where('idhackathon', $request->idhackathon)
            ->where('idequipe', $equipe->idequipe)
            ->first();

        if (!$inscription || $inscription->datedesinscription != null) {
            // Si l'inscription n'existe pas, retournez un message d'erreur
            return redirect()->back()->withErrors(['Erreur' => "Seuls les participants ayant participé au hackathon peuvent commenter !"])->withInput();
        }


        DB::table('INSCRIRE')
            ->where('idhackathon',$request->idhackathon )
            ->where('idequipe', $equipe->idequipe)
            ->update(['commentaire' => $request->post('commentaire')]);

        return view('commentaire', ["hackathon" => $hackathon, "equipe" => $equipe,  "commentaires" => $commentaires]);

    }

    public function fetchComments($id)
    {
        $commentaires = Inscrire::with('equipe')
                        ->where('idhackathon', $id)
                        ->whereNotNull('commentaire')
                        ->get();

        return view('partials.commentaires', compact('commentaires'));
    }

    
}
