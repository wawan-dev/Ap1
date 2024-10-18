@extends('layouts.app')

@section('custom-css')
    <link href="/css/home.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
    <div class="card w-60">
        <div class="text-center">
            <h3>Historique des hackathons</h3>
            <br>

            <!-- Formulaire de recherche -->
            <form method="GET" action="{{ route('filtrer_n') }}" class="d-flex justify-content-center align-items-center mb-3">
                <label for="search" class="me-2">Rechercher par nom :</label>
                <input type="text" name="search" id="search" class="form-control w-50" placeholder="Nom de l'hackathon" value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-primary ms-2">Rechercher</button>
            </form>

            @foreach ($hackathon as $h)
                <!-- Chaque hackathon est espacé avec mb-3 et les boutons sont alignés -->
                <div class="d-flex justify-content-between align-items-center mb-2"> 
                     <p class="mb-0">{{ $h->thematique }}</p>
                    <a href="/" class="btn bg-green m-2 button-home">Détail de l'hackathon</a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $hackathon->links("pagination::bootstrap-5") }} 
        </div>
    </div>
</div>
@endsection



