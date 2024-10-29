@extends('layouts.app')

@section('custom-css')
    <link href="/css/home.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
    <div class="card w-75">
        <h3 class="text-center">Commentaires sur {{$hackathon->thematique}}</h3>
        
        <div class="row">
            <div class="col-md-6 p-5"> 
                
                <div class="bg-light p-3" style="max-height: 400px; overflow-y: auto;">
                    
                </div>
            </div>

            <div class="col-md-6 p-4">
                <h4>Ajouter un commentaire :</h4>
                <form method="POST" action="{{ route('ajouter_commentaire', ['idhackathon' => $hackathon->idhackathon]) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="commentaire" rows="5" class="form-control" placeholder="Votre commentaire ici..." required></textarea>
                    </div>
                    <button type="submit" class="btn bg-green m-2 button-home" >Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



