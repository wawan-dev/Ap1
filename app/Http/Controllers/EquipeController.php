<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Membre;
use App\Models\Inscrire;
use App\Models\Collecter;
use App\Models\Hackathon;
use App\Utils\EmailHelpers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Utils\SessionHelpers;
use App\Models\Administrateur;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\Controller;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\BinaryOp\Equal;

class EquipeController extends Controller
{
    /**
     * Affiche la page de connexion.
     *
     * L'équipe se connecte avec son email et son mot de passe.
     * Le formulaire soumet les données à la route connect (POST).
     */
    public function login()
    {
        return view('equipe.login');
    }

    /**
     * Méthode de connexion de l'équipe.
     * Vérifie les informations de connexion et connecte l'équipe.
     */
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
        $equipe= Equipe::where('login', $validated['email'])->first();

        // Si l'équipe n'existe pas, on redirige vers la page de connexion avec un message d'erreur
        if (!$equipe) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipess n'a été trouvée avec cet email."]);
        }

        // Si le mot de passe est incorrect, on redirige vers la page de connexion avec un message d'erreur
        // Le message d'erreur est volontairement vague pour des raisons de sécurité
        // En cas d'erreur, on ne doit pas donner d'informations sur l'existence ou non de l'email
        if (!password_verify($validated['password'], $equipe->password)) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        session(['login' => $equipe->login]);
        if($equipe->active == 0 ){
            SessionHelpers::login($equipe);
            $log = new Logs();
            $log->idequipe = $equipe->idequipe;
            $log->description = "Connection de l'équipe";
            $log->save();
            return redirect("/me");
        }else{
        return redirect("/2FA");}
    }


    public function code_2FA(Request $request) {
        $equipe= Equipe::where('login', session('login'))->first();
        $request->validate([
            '2FA' => 'required|string', // Assurez-vous que le nom du champ correspond à celui du formulaire
        ]);
    
        $google2fa = new Google2FA();
    
        // Vérifier si le code est correct
        $isValid = $google2fa->verifyKey($equipe->google2fa_secret, $request->input('2FA'));
    
        if ($isValid) {
            // Code valide - l'utilisateur peut être authentifié
            SessionHelpers::login($equipe);
            return redirect('/me');
        }
        else{return redirect('/2FA');}
    }


    public function double_auth() {
        // Récupérer l'utilisateur authentifié
        $equipe= Equipe::where('login', session('login'))->first();
        
        // Vérifier que l'utilisateur a une clé secrète configurée
        if (!$equipe->google2fa_secret) {

            $cle_secret = Str::random(10);
            $equipe->cle_secret = $cle_secret;
            $equipe->active = 1;
            $google2fa = new Google2FA();
            $equipe->google2fa_secret = $google2fa->generateSecretKey();
            $equipe->save();

            $log = new Logs();
            $log->idequipe = $equipe->idequipe;
            $log->description = "Ajout du 2FA pour l'équipe";
            $log->save();

            $google2fa_url = $google2fa->getQRCodeUrl(
                'Hackath inov', // Remplacez par le nom de votre application
                $equipe->login,
                $equipe->google2fa_secret
            );
        
            return view('2fa_deb', [
                'google2fa_url' => $google2fa_url,
                'secret' => $equipe->google2fa_secret,
                'cle_secret'=> $equipe->cle_secret,
            ]);
        }
        else{
            
            return view('2FAform');
        }
    }

    public function check2FA(Request $request)
    {
        $equipe= Equipe::where('login', session('login'))->first();
        if ($request->has('active2FA')) {
            return redirect("/2FA") ;
        }

        else{
            $log = new Logs();
            $log->idequipe = $equipe->idequipe;
            $log->description = "Demande pour retirer le 2FA";
            $log->save();
            return view("retirer_auth");
            $equipe->active = 0;
            $equipe->google2fa_secret = null;
            $equipe->cle_secret = null;
            $equipe->save();
            SessionHelpers::login($equipe);
            return redirect("/me");
        }
    }


    public function dir2fa(){

        return view('2FAform');
    }

    public function retirer_auth(Request $request){
        $equipe= Equipe::where('login', session('login'))->first();
        $equipe->cle_secret_verif = $request->get('code_secret');
        $equipe->save();
        SessionHelpers::login($equipe);
        return redirect('/me');
    }

    

    /**
     * Méthode de création d'une équipe.
     * Affiche le formulaire de création d'équipe.
     */
    public function create(Request $request)
    {
        // Si l'équipe est déjà connectée, on la redirige vers sa page de profil
        if (SessionHelpers::isConnected()) {
            return redirect("/me");
        }

        // Si le formulaire n'a pas été soumis, on affiche le formulaire de création d'équipe
        if (!$request->isMethod('post')) {
            return view('equipe.create', []);
        }

        // Sinon, on traite les données du formulaire
        // Validation des données, on vérifie que les champs sont corrects.
        $request->validate(
            [
                'nom' => 'required|string|max:255',
                'lien' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:EQUIPE,login',
                'password' => 'required|string|min:8',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
                'unique' => 'Cette adresse :attribute est déjà utilisée.',
                'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            ],
            [
                'nom' => 'nom',
                'lien' => 'lien',
                'email' => 'email',
                'password' => 'mot de passe',
            ]
        );

        // Récupération du hackathon actif
        $hackathon = Hackathon::getActiveHackathon();

        // Si aucun hackathon n'est actif, on redirige vers la page de création d'équipe avec un message d'erreur
        if (!$hackathon) {
            return redirect("/create-team")->withErrors(['errors' => "Aucun hackathon n'est actif pour le moment. Veuillez réessayer plus tard."]);
        }

        try {
            // Création de l'équipe
            $equipe = new Equipe();
            $equipe->nomequipe = $request->input('nom');
            $equipe->lienprototype = $request->input('lien');
            $equipe->login = $request->input('email');
            $equipe->password = bcrypt($request->input('password'));
            $equipe->active = 0;
            $equipe->save();

            // Envoi d'un email permettant de confirmer l'inscription
            EmailHelpers::sendEmail($equipe->login, "Inscription de votre équipe", "email.create-team", ['equipe' => $equipe]);

            // Connexion de l'équipe
            SessionHelpers::login($equipe);

            // L'équipe rejoindra le hackathon actif.
            // On crée une inscription pour l'équipe (table INSCRIRE)
            Inscrire::create([
                'idequipe' => $equipe->idequipe,
                'idhackathon' => $hackathon->idhackathon,
                'dateinscription' => date('Y-m-d H:i:s'),
            ]);
            EmailHelpers::sendEmail($equipe->login, "Hackaton rejoins avec succès", "email.joinemail", ['equipe' => $equipe, 'hackaton' => $hackathon,'organisateur' => $hackathon->organisateur]);


            // Redirection vers la page de profil de l'équipe avec un message de succès
            return redirect("/me")->with('success', "Votre équipe a bien été créée. Vérifiez votre boîte mail pour confirmer votre inscription.");
        } catch (\Exception $e) {
            // Redirection vers la page de création d'équipe avec un message d'erreur
            return redirect("/create-team?idh=" . $request->idh)->withErrors(['errors' => "Une erreur est survenue lors de la création de votre équipe."]);
        }

    }

    /**
     * Méthode de déconnexion, vide la session et redirige vers la page d'accueil.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        SessionHelpers::logout();
        return redirect()->route('home');
    }


    /**
     * Méthode de visualisation de la page de profil de l'équipe.
     * Permet de voir les informations de l'équipe, les membres, et d'ajouter des membres.
     */
    public function me()
    {
        // Si l'équipe n'est pas connectée, on la redirige vers la page de connexion
        if (!SessionHelpers::isConnected()) {
            return redirect("/login");
        }

        // Récupération de l'équipe connectée
        $equipe = SessionHelpers::getConnected();

        $inscription = Inscrire::getinscription($equipe->idequipe);

        // Récupération des membres de l'équipe
        $membres = $equipe->membres;

        // Récupération du hackathon ou l'équipe est inscrite
        $hackathon = $equipe->hackathons()->get();

        // Membre de l'équipe,
        // Membre::where('idequipe', $equipe->idequipe)->get(); // Ancienne méthode
        // Voir la méthode membres() dans le modèle Equipe équivalente à la ligne précédente.
        $membres = $equipe->membres()->get();

        return view('equipe.me', ['connected' => $equipe, 'membres' => $membres, 'hackathon' => $hackathon, 'membres' => $membres, 'inscription'=>$inscription]);
    }

    /**
     * Méthode d'ajout d'un membre à l'équipe.
     */
    public function addMembre(Request $request)
    {
        // Ajout d'un membre à l'équipe
        $equipe = SessionHelpers::getConnected();

        // Validation des données, pour l'instant nous n'avons que NOM et PRENOM.
        // TODO : À l'avenir ajouter l'ensemble des champs nécessaires prévus dans la base de données.

        $request->validate(
            [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'telephone' => 'required|string|max:10',
                'naiss' => 'required|date',


            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
            ],
            [
                'nom' => 'nom',
                'prenom' => 'prénom',
                'email' => 'email',
                'telephone' => 'telephone',
                'datenaissance' => 'naiss',
                
                
            ]
        );

        try {
            // Création du membre
            $membre = new Membre();
            $membre->nom = $request->input('nom');
            $membre->prenom = $request->input('prenom');
            $membre->email = $request->input('email');
            $membre->telephone = $request->input('telephone');
            $membre->datenaissance = $request->input('naiss');
            $membre->lienportfolio = $request->input('portfolio');
            $membre->idequipe = $equipe->idequipe;
            $membre->save();

            // TODO : envoyer un email de confirmation au membre en s'inspirant de la méthode create de EquipeController (emailHelpers::sendEmail)
            EmailHelpers::sendEmail($membre->email, "Nouveau membre hackathon", "email.newmembre", ['membre' => $membre, 'equipe'=>$equipe]);
            // Redirection vers la page de l'équipe
            return redirect("/me")->with('success', "Le membre a bien été ajouté à votre équipe.");
        } catch (\Exception $e) {
            // Redirection vers la page de l'équipe avec un message d'erreur
            return redirect("/me")->withErrors(['errors' => "Une erreur est survenue lors de l'ajout du membre à votre équipe."]);
        }
    }

    public function supp_membre($id){
        $membre = Membre::find($id);
        $membre->delete();
     
        return redirect("/me")->with(['success' => "Le membre à bien été supprimer"]);
    }

    public function modif_equipe($idequipemod){
        $equipe = Equipe::find($idequipemod);
        return view('equipe.modif', ['connected' => $equipe,]);
    }

    public function verif_modif_equipe(Request $request, $idequipe){
        $equipe = Equipe::find($idequipe);
        $nom = $request->input('name');
        $email = $request->input('email');
        $NewPassword = $request->input('NewPassword');
        $VerifyNewPassword = $request->input('VerifyNewPassword');

        if($NewPassword == $VerifyNewPassword){
            if($equipe->password == bcrypt($NewPassword)){

                return redirect("/modif_equipe/$idequipe")->withErrors(['errors' => "Vous pouver pas remettre le même mot de passe que avant"]);
            }

            if($NewPassword =='' && $VerifyNewPassword==''){
                $equipe->nomequipe = $nom;
                $equipe->login = $email;
                $equipe->save();
            }
            else{
                if(strlen($NewPassword)>=8){
                    $equipe->nomequipe = $nom;
                    $equipe->login = $email;
                    $equipe->password = bcrypt($NewPassword);
                    $equipe->lienprototype = '123';
                    $equipe->save();
                }
                else{
                    return redirect("/modif_equipe/$idequipe")->withErrors(['errors' => "Votre nouveau mot de passe doit faire minimum 8 caractères"]);
                }
            }
            return redirect("/me")->with(['success' => "modification réussie !"]);
        }
        else{
            return redirect("/modif_equipe/$idequipe")->withErrors(['errors' => "Les mots de passe saisie ne sont pas identiques."]);
        }

    }

    public function collecter_donner(Equipe $equipe){

    
        $data = [
            'equipe' => $equipe->toArray(),
            'membres' => $equipe->membres->toArray(),
            'log' => $equipe->logs
        ];

        
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);

        
        $fileName = "collecte_equipe_{$equipe->idequipe}.json";
        
        Storage::put("public/{$fileName}", $jsonContent);

        $filePath = storage_path("app/public/{$fileName}");

        $admin = SessionHelpers::getConnectedAdmin();

        
        $collecte = new Collecter();
        $collecte->idequipe = $equipe->idequipe;
        $collecte->idadministrateur =$admin->idadministrateur ;
        $collecte->date = now();
        $collecte->save();
        
    

        if (file_exists($filePath)) {
            
            EmailHelpers::sendEmail(
                $admin->email, 
                "Demande de donnée équipe $equipe->nomequipe", 
                "email.collecterdonne", 
                [
                    'attachment' => $filePath,
                    'equipe' => $equipe
                ]
            );
            
            // Retour à la page précédente avec un message de succès
            return redirect()->back()->with('success', 'Demande de collecte envoyée avec succès.');
        }
    
        
    }

    
}
