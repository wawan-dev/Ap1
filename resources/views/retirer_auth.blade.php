@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
        <div class="wrapper fadeInDown">
            <form action="{{ route('retirer_auth') }}" method="POST" id="formContent">
                @csrf <!-- Ajoute le token CSRF pour protéger la requête POST -->
                
                <div class="p-5">
                    <label class="text-justify">
                        Pour retirer la double authentification, il vous faut fournir le code secret de réinitialisation fourni lors de l'activation de la première double authentification.
                        Un temps d'attente de quelques minutes est nécessaire pour la validation du retrait de la double authentification.
                    </label>
                    
                    <input type="text" id="code_secret" class="fadeIn second" name="code_secret" placeholder="Code de réinitialisation" required />
                </div>
                
                <button type="submit" class="btn btn-primary mt-3 fadeIn third m-5">Envoyer le code</button>
            </form>
        </div>
    </div>

@endsection