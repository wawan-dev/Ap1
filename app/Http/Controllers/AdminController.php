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

        // Récupération de l'équipe avec l'email fourni
        $admin = Administrateur::where('email', $validated['email'])->first();

        // Si l'équipe n'existe pas, on redirige vers la page de connexion avec un message d'erreur
        if (!$admin) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Aucun Administrateursss n'a été trouvée avec cet email."]);
        }

        // Si le mot de passe est incorrect, on redirige vers la page de connexion avec un message d'erreur
        // Le message d'erreur est volontairement vague pour des raisons de sécurité
        // En cas d'erreur, on ne doit pas donner d'informations sur l'existence ou non de l'email
        if (!password_verify($validated['password'],  $admin->motpasse)) {
            return redirect("/loginAdmin")->withErrors(['errors' => "Aucun Administrateur n'a été trouvée avec cet email."]);
        }

        // Connexion de l'équipe
        SessionHelpers::loginadmin($admin);

        // Redirection vers la page de profil de l'équipe
        return redirect("/doc-api");
    }

    public function logoutadmin()
    {
        SessionHelpers::logoutadmin();
        return redirect()->route('home');
    }
}
