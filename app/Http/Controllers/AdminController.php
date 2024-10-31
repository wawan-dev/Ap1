<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use App\Utils\SessionHelpers;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function loginadmin()
    {
        return view('admin.loginadmin');
    }

    public function connect(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
            ],
            [
                'email' => 'email',
                'password' => 'mot de passe',
            ]
        );

        
        $admin = Administrateur::where('email', $validated['email'])->first();

        
        if (!$admin) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Aucun Administrateursss n'a été trouvée avec cet email."]);
        }

        
        if (!password_verify($validated['password'],  $admin->motpasse)) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Aucun Administrateur n'a été trouvée avec cet email."]);
        }

        // Connexion de l'équipe
        SessionHelpers::loginadmin($admin);

        
        return redirect("/doc-api");
    }

    public function logoutadmin()
    {
        SessionHelpers::logoutadmin();
        return redirect()->route('home');
    }
}
