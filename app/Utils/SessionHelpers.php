<?php

namespace App\Utils;

use App\Models\Administrateur;
use App\Models\Equipe;

class SessionHelpers
{
    static string $sessionKey = "LOGIN";
    static string $sessionKeyAdmin = "ADMIN";

    /**
     * Connecte une équipe, c'est-à-dire stocke l'équipe dans la session
     * @param Equipe $equipe
     * @return void
     */
    static function login(Equipe $equipe): void
    {
        session()->put(self::$sessionKey, $equipe);
        session()->save();
        session()->forget(self::$sessionKeyAdmin);
    }

    static function loginAdmin(Administrateur $admin): void
    {
        session()->put(self::$sessionKeyAdmin, $admin);
        session()->forget(self::$sessionKey);
        session()->save();
    }

    /**
     * Déconnecte une équipe, c'est-à-dire supprime l'équipe de la session
     * @return void
     */
    static function logout(): void
    {
        session()->forget(self::$sessionKey);
        session()->save();
    }

    static function logoutadmin(): void
    {
        session()->forget(self::$sessionKeyAdmin);
        session()->save();
    }

    /**
     * Retourne l'équipe connectée, ou null si aucune équipe n'est connectée
     * @return Equipe|null
     */
    static function getConnected(): ?Equipe
    {
        return session(self::$sessionKey, null);
    }

    static function getConnectedAdmin(): ?Administrateur
    {
        return session(self::$sessionKeyAdmin, null);
    }

    /**
     * Vérifie si une équipe est connectée. Retourne true si une équipe est connectée, false sinon
     * @return bool
     */
    static function isConnected(): bool
    {
        return session()->has(self::$sessionKey);
    }

    static function isConnectedAdmin(): bool
    {
        return session()->has(self::$sessionKeyAdmin);
    }



    public static function flash(string $type, $message)
    {
        session()->flash($type, $message);
    }
}
