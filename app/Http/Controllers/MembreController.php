<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function afficher_membre(Equipe $equipe){
        $lesMembre = $equipe->membres;
        return view('membre.affiche', ['lesmembres' => $lesMembre]);
    }
}
