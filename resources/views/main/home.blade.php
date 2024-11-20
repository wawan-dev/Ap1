@extends('layouts.app')

@section('title', ' - Bienvenue')

@section('custom-css')
    <link href="/css/home.css" rel="stylesheet"/>
@endsection

@section('content')
    <div v-scope v-cloak class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg ">
        <div class="row">
            <div class="col-10">
                <h1>Bienvenue sur Hackat'innov 👋</h1>
            </div>
            <div class="col-2">
            <img src="/img/logo.png" style="padding-left: 50%; " alt="Affiche de l'évènement.">
            </div>
        </div>
        <div class="col-12 col-md-9 d-flex">
        <?php
        
        ?>

        <img src="/img/affiche.png" class="affiche d-md-block d-none" alt="Affiche de l'évènement.">
            <div class="px-5" v-if="!participantsIsShown">
                <h2><?= $hackathon->thematique ?></h2>
                <p><?= nl2br($hackathon->objectifs) ?></p>
                <p><?= nl2br($hackathon->conditions) ?></p>

                <div class="card w-100">
                    <div>Informations :</div>
                    <div><em>Date :</em> <?= date_create($hackathon->dateheuredebuth)->format("d/m/Y H:i") ?>
                        au <?= date_create($hackathon->dateheurefinh)->format("d/m/Y H:i") ?></div>
                    <div><em>Lieu :</em> <?= $hackathon->ville ?></div>
                    <div><em>Organisateur :</em> <?= "{$organisateur->nom} {$organisateur->prenom}" ?></div>
                    <br>
                    @if($hackathon->nbplaceeqmax - $nbplace == 0) 
                    <p>Désolé cet hackaton à atteint le nombre maximum de place.</p> 
                    @endif
                    @if($hackathon->nbplaceeqmax - $nbplace == 1) 
                    <p>Il ne reste plus que {{$hackathon->nbplaceeqmax - $nbplace }} place</p>
                    @endif
                    @if($hackathon->nbplaceeqmax - $nbplace > 1) 
                    <p>Il ne reste plus que {{$hackathon->nbplaceeqmax - $nbplace }} places</p>
                    @endif
                   
                </div>

                <!-- Affichage des messages d'erreurs -->
                @if ($errors->any())
                    <div class="alert alert-danger shadow-none mt-3 mb-0">
                        <ul class="list-unstyled text-start m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex flex-wrap pt-3">
                    
                    @if($hackathon->nbplaceeqmax > $nbplace && \Carbon\Carbon::now()->lt($hackathon->datefininscription)   )
                    <a class="btn bg-green m-2 button-home" href="{{ route('join', ['idh' => $hackathon->idhackathon]) }}">Rejoindre</a>
                    <a class="btn bg-green m-2 button-home" href="{{route('create-team')}}">Créer mon équipe</a>
                        
                    @endif
                    @foreach($equipeinscrit as $n)
                        @if($connected)
                            @if(\Carbon\Carbon::now()->lt($hackathon->datefininscription) && $n->idequipe == $connected->idequipe  && $n->datedesinscription == null)
                        
                                <a class="btn bg-green m-2 button-home" href="{{ route('quit-hackathon', ['n' => $n->idhackathon, 'co' => $n->idequipe]) }}" 
                                onclick="return confirm('Êtes-vous sûr de vouloir quitter ce hackathon ?');">
                                Quitter l'hackathon
                                </a>

                            @endif

                        @endif

                    @endforeach

                    @if(\Carbon\Carbon::now()->gt($hackathon->dateheurefinh))
                        <a class="btn bg-green m-2 button-home" href="{{ route('commentaire', ['idh' => $hackathon->idhackathon]) }}">Commentaire</a>
                    @endif

                    <a class="btn bg-green m-2 button-home" href="{{ route('statistique_hack', ['idh' => $hackathon->idhackathon]) }}">Statistique</a>

                    <a class="btn bg-green m-2 button-home" href="#" @click.prevent="getParticipants">
                        <span v-if="!loading">Les participants</span>
                        <span v-else>Chargement en cours…</span>
                    </a>
                </div>
            </div>
            <div v-if="participantsIsShown">
                <a class="btn bg-green m-2 button-home" href="#" @click.prevent="participantsIsShown = false">←</a> Listes des participants
                <ul class="pt-3">
                    @foreach($equipeinscrit as $n)
                        @if($n->datedesinscription == null)
                            <li class="member">
                                🧑‍💻 {{ $n->nomequipe }}
                                <a class="btn bg-info m-2 button-default" href="/affiche/{{ $n->idequipe }}">
                                    Consulter les membres de : {{ $n->nomequipe }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <!-- Petite Vue, version minimal de VueJS, voir https://github.com/vuejs/petite-vue -->
    <!-- v-scope, @click, v-if, v-else, v-for : sont des éléments propre à VueJS -->
    <!-- Pour plus d'informations, me demander ou voir la documentation -->
    <script type="module">
        import {createApp} from 'https://unpkg.com/petite-vue?module'

        createApp({
            participants: [],
            participantsIsShown: false,
            loading: false,
            getParticipants() {
                if (this.participants.length > 0) {
                    // Si nous avons déjà chargé les participants, alors on utilise la liste déjà obtenue.
                    this.participantsIsShown = true
                } else {
                    this.loading = true;

                    // Sinon on charge via l'API la liste des participants
                    fetch("/api/hackathon/<?= $hackathon->idhackathon ?>/equipe")
                        .then(result => result.json()) // Transforme le retour de l'API en tableau de participants
                        .then(participants => this.participants = participants) // Sauvegarde la liste.
                        .then(() => this.participantsIsShown = true) // Affiche la liste
                        .then(() => this.loading = false) // Arrêt de l'état chargement
                }
            }
        }).mount()
    </script>
@endsection
