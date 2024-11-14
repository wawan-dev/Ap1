@extends('layouts.app')

@section('title', ' - Affichage des Membres')

@section('content')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer" >
        <div class="wrapper fadeInDown" >
            <div class="cardRadius">
                <br>
                <h1>Liste des membres :</h1>
                <br>
                @foreach($lesmembres as $membre)
                    
                    <p> {{$membre->nom}}  {{$membre->prenom}} </p>
                @endforeach
                <br>
                <br>
                <a class="btn btn-primary mt-3 fadeIn third m-5" href="/"  @click.prevent="participantsIsShown = true"><--</a>
            </div>
        </div>
    </div>
@endsection




