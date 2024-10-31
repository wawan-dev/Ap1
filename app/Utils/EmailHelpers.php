<?php

namespace App\Utils;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;


class EmailHelpers
{
    public static function sendEmail($to, $subject, $template, $data = [])
    {
        // Générer le corps HTML à partir du modèle
        $body = View::make($template, $data)->render();

        // Préparer l'e-mail
        Mail::send([], [], function ($message) use ($to, $subject, $body, $data) {
            $message->to($to)
                ->subject($subject)
                ->html($body); // Utilisation de la méthode html() pour définir le corps en HTML

            // Vérifiez si une pièce jointe est fournie dans les données
            if (isset($data['attachment'])) {
                $message->attach($data['attachment']); // Attache le fichier
            }
        });
    }
}

