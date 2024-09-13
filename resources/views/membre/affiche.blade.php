@extends('layouts.app')

@section('title', ' - Affichage des Membres')

@section('content')


<div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
<br>
    <h1>Liste des Membre :</h1>
    <br>
    @foreach($lesmembres as $membre)
        <p> {{$membre->nom}}  {{$membre->prenom}} </p>
    @endforeach
</div>



@endsection
