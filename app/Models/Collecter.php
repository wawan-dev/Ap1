<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collecter extends Model
{
    use HasFactory;
    protected $table = 'COLLECTER';

    public $incrementing = false;
    protected $fillable = ['idequipe', 'idadministrateur', 'date', 'commentaire'];


    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe');
    }

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'idadministrateur');
    }
}
