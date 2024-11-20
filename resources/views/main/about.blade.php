@extends('layouts.app')

@section('title', ' - À propos')

@section('content')
    <div  class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg ">
    
    <div class="text-center my-5 " style="background-color: rgba(128, 128, 128, 0.5); padding:20px; border-radius: 20px;">
            <h1>À propos des Hackathons</h1>
            <p>Les hackathons sont des événements collaboratifs où des développeurs, des designers et des entrepreneurs se réunissent pour innover et créer des solutions en un temps limité.</p>
        </div>

        <div class="mb-4" style="background-color: rgba(128, 128, 128, 0.5); padding:20px; border-radius: 20px;">
            <h2>Pourquoi Participer à un Hackathon ?</h2>
            <ul>
                <li>**Innovation** : Créez des prototypes et des solutions innovantes.</li>
                <li>**Collaboration** : Rencontrez des personnes partageant les mêmes idées et élargissez votre réseau professionnel.</li>
                <li>**Apprentissage** : Améliorez vos compétences en travaillant sur des projets concrets.</li>
                <li>**Visibilité** : Montrez vos compétences à des entreprises et des investisseurs potentiels.</li>
            </ul>
        </div>

        <div class="mb-4" style="background-color: rgba(128, 128, 128, 0.5); padding:20px; border-radius: 20px;">
            <h2>Règles de Participation</h2>
            <p>Pour garantir une expérience positive pour tous les participants, nous avons mis en place quelques règles :</p>
            <ul>
                <li>**Respect** : Traitez tous les participants avec respect et courtoisie.</li>
                <li>**Équipe** : Formez des équipes de 3 à 5 personnes. Les participants individuels peuvent être regroupés.</li>
                <li>**Projets** : Tous les projets doivent être originaux et créés durant l'événement.</li>
                <li>**Soumission** : Les projets doivent être soumis avant la date limite spécifiée.</li>
            </ul>
        </div>
        
        <div class="text-center my-5" style="background-color: rgba(128, 128, 128, 0.5); padding:20px; border-radius: 20px;">
            <h1>Nos convictions</h1>
            <p>A l'oragnisation des hackaton, nous nous engageons à fournir un service de qualité qui respecte les droits et la vie privée de nos utilisateurs. Nous croyons en la transparence et en l'importance de protéger vos données personnelles.</p>
        </div>
        <br>
        <br>
        <br>
        <div class="mb-4" style="background-color: rgba(128, 128, 128, 0.5); padding:20px; border-radius: 20px;">
            
            <h3>Protection des données personnelles (RGPD)</h3>
            <p>Conformément au Règlement Général sur la Protection des Données (RGPD), nous vous informons que toutes les données collectées sur notre plateforme sont traitées de manière sécurisée et transparente. Vous avez le droit d'accéder à vos données, de les rectifier ou de demander leur suppression.</p>
            <br>
            <br>
            <br>
            <h3>Utilisation des cookies</h3>
            <p>Nous utilisons des cookies pour améliorer votre expérience sur notre site. Les cookies sont de petits fichiers texte qui sont stockés sur votre appareil. Ils nous aident à analyser le trafic du site et à personnaliser le contenu que nous vous proposons. Vous pouvez gérer vos préférences de cookies via les paramètres de votre navigateur.</p>
        </div>
        <br>
        <br>
        <br>
        <div class="text-center" style="background-color: rgba(128, 128, 128, 0.5); padding:20px; border-radius: 20px;">
            <h2>Nous Contacter</h2>
            <p>Pour toute question ou demande d'information supplémentaire, n'hésitez pas à nous contacter à <a href="mailto:contact@cejm.fr">hackaton@gmail.fr</a>.</p>
        </div>
    </div>
@endsection
