<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    
    protected $table = 'ADMINISTRATEUR';
    protected $primaryKey = 'idaministarteur';
    public $timestamps = false;

    protected $fillable = ['nom', 'prenom', 'motpasse', 'email'];

}
