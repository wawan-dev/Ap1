<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;

class historiqueController extends Controller
{
    public function Listerhackaton(){
        
        $hackathon = Hackathon::paginate(10);
        return view('historique',['hackathon' => $hackathon]);
    }
}
