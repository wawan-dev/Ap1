<?php

namespace App\Http\Controllers;

use App\Models\Inscrire;
use App\Models\Hackathon;
use App\Utils\EmailHelpers;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\DB;

class HackathonController extends Controller
{
    public function join(Request $request){
        // Si l'équipe n'est pas connectée, on redirige vers la page de connexion
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
        }
        

        // Récupération de l'équipe connectée
        $equipe = SessionHelpers::getConnected();

      
        $idh = $request->query('idh');
        $hackathon = Hackathon::find($idh);

        $inscrire = DB::table('INSCRIRE')->where('idhackathon', $idh)->where('idequipe', $equipe->idequipe)->first();
        if($inscrire != null && $inscrire->datedesinscription){
            return redirect("/")->withErrors(['Erreur' => "Vous pouvez pas vous réinscrire après une désinscription"]);
        }

       
        try{
            // Inscription de l'équipe au hackathon
            $inscription = new Inscrire();
            $inscription->idhackathon = $idh;
            $inscription->idequipe = $equipe->idequipe;

            


            $inscription->dateinscription = today();
            $inscription->save();

            // TODO : envoyer un email de confirmation à l'équipe en utilisant la classe EmailHelpers, et la méthode sendEmail (exemple présent dans le contrôleur EquipeController)
            EmailHelpers::sendEmail($equipe->login, "Hackaton rejoins avec succès", "email.joinemail", ['equipe' => $equipe, 'hackaton' => $hackathon,'organisateur' => $hackathon->organisateur]);

            // Redirection vers la page de l'équipe
            return redirect("/me")->with('success', "Inscription réussie, vous faites maintenant partie du hackathon.");
        } catch (\Exception $e) {
            // Redirection vers la page d'accueil avec un message d'erreur
            return redirect("/")->withErrors(['Erreur' => "Vous êtes déja inscrit pour cette hackathon !"]);
        }
    }
    

    public function quitterhackathon($idhack, $idequipe) {
        
            if (!SessionHelpers::isConnected()) {
                return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
            }
    
            DB::table('INSCRIRE')
            ->where('idhackathon', $idhack)
            ->where('idequipe', $idequipe)
            ->update(['datedesinscription' => now()]);
        
            // Affecter la date de désinscription et sauvegarder

    
            return redirect("/")->with('success', "Désinscription réussie.");
        }
        
    
    
    

    
}
