<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiDocController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\historiqueController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MembreController;
use App\Http\Middleware\IsAdminConnected;
use App\Http\Middleware\IsEquipeConnected;
use App\Models\Administrateur;
use App\Models\Equipe;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\Route;

include('inc/api.php');

// Routes de base
Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/about', [MainController::class, 'about'])->name('about');

// Routes d'authentification et de gestion d'équipe
Route::get('/login', [EquipeController::class, 'login'])->name('login');
Route::post('/login', [EquipeController::class, 'connect'])->name('connect');
Route::get('/home/{id}', [MainController::class, 'home_id']);
Route::any('/create-team', [EquipeController::class, 'create'])->name('create-team');
Route::get('/loginAdmin', [AdminController::class, 'loginadmin']);
Route::post('/loginAdmin', [AdminController::class, 'connect']);

Route::post('/code_2FA', [EquipeController::class, 'code_2FA'])->name('code_2FA');
Route::get('/2FA', [EquipeController::class, 'double_auth'])->name('double_auth');


//Route pour les membres
Route::get('/affiche/{equipe}', [MembreController::class, 'afficher_membre']);



// Routes protégées nécessitant une session active, pour les équipes.
// Proctection par le middleware IsEquipeConnected (voir app/Http/Middleware/IsEquipeConnected.php)
Route::middleware(isEquipeConnected::class)->group(function () {
    Route::get('/logout', [EquipeController::class, 'logout'])->name('logout');
    Route::get('/me', [EquipeController::class, 'me'])->name('me');
    Route::post('/membre/add', [EquipeController::class, 'addMembre'])->name('membre-add');
    Route::get('/modif_equipe/{id}', [EquipeController::class, 'modif_equipe']);
    Route::post('/modif_equipe/{id}', [EquipeController::class, 'verif_modif_equipe']);
    Route::any('/quit-hackathon/{n}/{co}', [HackathonController::class, 'quitterhackathon'])->name('quit-hackathon');

    Route::get('/supp_membre/{id}', [EquipeController::class, 'supp_membre']);
    Route::get('/supp_membre/{id}', [EquipeController::class, 'supp_membre']);
    Route::get('/join', [HackathonController::class, 'join'])->name('join');

    Route::get('/commentaire', [CommentaireController::class, 'commenter'])->name('commentaire');
    Route::post('/ajouter_commentaire', [CommentaireController::class, 'ajouter_commenter'])->name('ajouter_commentaire');
    
});

Route::middleware(IsAdminConnected::class)->group(function () {
    // Routes de l'API pour la documentation et les listes
    Route::get('/doc-api/', [ApiDocController::class, 'liste'])->name('doc-api');
    Route::get('/doc-api/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
    Route::get('/doc-api/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
    Route::get('/doc-api/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');

    Route::get('/collecter/{equipe}', [EquipeController::class, 'collecter_donner'])->name('collecter');
    Route::get('/logoutadmin', [AdminController::class, 'logoutadmin']);
});

Route::get('/historique', [historiqueController::class, 'Listerhackaton'])->name('historique');
Route::get('/filtre_nom', [historiqueController::class, 'filtrer_n'])->name('filtrer_n');

Route::get('/fetch-comments/{id}', [CommentaireController::class, 'fetchComments'])->name('fetch-comments');

