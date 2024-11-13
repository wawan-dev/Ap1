<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'EQUIPE';
    protected $primaryKey = 'idequipe';
    public $timestamps = false;

    protected $fillable = ['nomequipe', 'lienprototype', 'nbparticipants', 'login', 'password','google2fa_secret','cle_secret','cle_secret_verif','active'];

    /**
     * Retourne les équipes inscrites à un hackathon.
     * @param $idHackathon
     * @return mixed
     */
    public static function getEquipesInHackhon($idHackathon)
    {
        // Ici on utilise DB::table pour faire une requête SQL directe
        // Cela permet de faire des requêtes comme on le ferait en SQL mais
        // en utilisant les avantages de Laravel (sécurité, etc.)
        // Tout en garand le type de retour (tableau d'objets Equipe)
        $equipes = DB::table('EQUIPE')
            ->join('INSCRIRE', 'EQUIPE.idequipe', '=', 'INSCRIRE.idequipe')
            ->where('INSCRIRE.idhackathon', $idHackathon)
            ->get()
            ->toArray();

        // Permet de transformer les objets stdClass en objets Equipe
        return Equipe::hydrate($equipes);

    }

    public static function getByToken($token)
    {
        return Token::where('uuid', $token)->first()->equipe;
    }

    public function membres()
    {
        return $this->hasMany(Membre::class, 'idequipe');
    }

   

    public function hackathons()
    {
        return $this->belongsToMany(Hackathon::class, 'INSCRIRE', 'idequipe', 'idhackathon')->withPivot('dateinscription');
    }

    public function inscrit()
    {
        return $this->belongsToMany(Hackathon::class, 'INSCRIRE', 'idequipe', 'idhackathon')->withPivot('dateinscription');
    }

    public function tokens()
    {
        return $this->hasMany(Token::class, 'idequipe');
    }

   
}
