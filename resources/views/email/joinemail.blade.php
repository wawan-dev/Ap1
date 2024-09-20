<!DOCTYPE html>
<html>

<head>
    <title>Inscription à l'hackaton de {{$hackaton->ville}}</title>
</head>

<body>
    <h1>Confirmation d'inscription à {{$hackaton->ville}}</h1>
    <p>Cher {{ $equipe->nomequipe }},</p>
    <p>Merci de votre inscription a notre hackaton. Nous sommes ravis de vous avoir parmi nous !</p>
    <p>L'hackaton aura lieu a la date du {{$hackaton->dateheuredebuth}}</p>
    <p>L'objectif de l'hackaton est : {{$hackaton->objectif}}.
        N'oubliez pas d'emmener tous le matériels nécessaire pour cet hackaton car nous ne pretons aucuns matériels : D .</p>
   
    <p>Pour tous question supplémentaire contacter : {{$organisateur->nom}} {{$organisateur->prenom}} som email est le suivant: {{$organisateur->email}}</p>
    <p>Cordialement,</p>
    <p>Votre équipe de Hackat'innov</p>
</body>

</html>
 