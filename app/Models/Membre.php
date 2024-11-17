<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membre extends Model
{
    use HasFactory;

    protected $table = 'MEMBRE';
    protected $primaryKey = 'idmembre';
    public $timestamps = false;

    protected $fillable = ['idequipe', 'nom', 'prenom', 'email', 'telephone', 'datenaissance', 'lienportfolio'];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe');
    }

    public static function getMembreInHackhon($idHackathon)
    {
        // Ici on utilise DB::table pour faire une requête SQL directe
        // Cela permet de faire des requêtes comme on le ferait en SQL mais
        // en utilisant les avantages de Laravel (sécurité, etc.)
        // Tout en garand le type de retour (tableau d'objets Equipe)
        $equipes = DB::table('EQUIPE')
            ->join('INSCRIRE', 'EQUIPE.idequipe', '=', 'INSCRIRE.idequipe')
            ->where('INSCRIRE.idhackathon', $idHackathon)
            ->whereNull('INSCRIRE.datedesinscription')
            ->get()
            ->toArray();
        $totale =0;
        foreach ($equipes as $equipe) {
            // Compter les membres pour chaque équipe
            $membresCount = DB::table('MEMBRE')
                ->where('idequipe', $equipe->idequipe)
                ->count();
    
            $totale += $membresCount;
        }
        return ($totale);

    }
}
