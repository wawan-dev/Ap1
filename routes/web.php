<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiDocController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\HackathonController;
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
Route::get('/join', [HackathonController::class, 'join'])->name('join');
Route::any('/create-team', [EquipeController::class, 'create'])->name('create-team'); // Any pour gérer les GET et POST
Route::get('/supp_membre/{id}', [EquipeController::class, 'supp_membre']);
Route::get('/supp_membre/{id}', [EquipeController::class, 'supp_membre']);
Route::get('/loginAdmin', [AdminController::class, 'loginadmin']);
Route::post('/loginAdmin', [AdminController::class, 'connect']);




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
});

Route::middleware(IsAdminConnected::class)->group(function () {
    // Routes de l'API pour la documentation et les listes
    Route::get('/doc-api/', [ApiDocController::class, 'liste'])->name('doc-api');
    Route::get('/doc-api/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
    Route::get('/doc-api/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
    Route::get('/doc-api/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');
});

