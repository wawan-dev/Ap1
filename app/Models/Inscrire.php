<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrire extends Model
{
    use HasFactory;

    protected $table = 'INSCRIRE';
    protected $primaryKey = ['idhackathon', 'idequipe'];

    // Vu que la clé primaire est composée de deux colonnes, on doit spécifier que la clé primaire n'est pas auto-incrémentée
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = ['idhackathon', 'idequipe', 'dateinscription','datedesinscription','commentaire'];

    public static function getinscription($idequipe)
    {
        return Inscrire::where('idequipe', $idequipe)->get();
    }

    public static function getallinscription()
    {
        return Inscrire::get();
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class, 'idhackathon');
    }
    
}
