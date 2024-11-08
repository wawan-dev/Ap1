
@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center min-vh-100">
    <div class="card w-50 mt-5 p-4">
        <h2 class="text-center">{{ __('Activer l\'authentification à deux facteurs') }}</h2>

        <p class="text-center mt-3">
            Pour configurer 2FA, scannez le code QR ci-dessous avec l'application Google Authenticator ou entrez la clé secrète manuellement.
        </p>

        <div class="d-flex justify-content-center mt-3">
            {!! QrCode::size(200)->generate($google2fa_url) !!}
        </div>

        <p class="text-center mt-3">
            <strong>Clé secrète :</strong> {{ $secret }}
        </p>

        <p class="text-center">
            Conservez cette clé dans un endroit sûr. Elle vous permettra de restaurer l'authentification 2FA si vous perdez l'accès à votre appareil.
        </p>

        
    </div>
</div>
@endsection