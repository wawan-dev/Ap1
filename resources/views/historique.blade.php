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

            
            <form method="GET" action="{{ route('filtrer_n') }}" class="d-flex justify-content-center align-items-center mb-3">
                 @csrf
                <label for="search" class="me-2">Rechercher par nom :</label>
                <input type="text" name="search" id="search" class="form-control w-50" placeholder="Nom de l'hackathon" value="{{ request()->get('search') }}">
                

                <select name="status" id="status" class="form-select m-5">
                    <option value="">Tous</option>
                    <option value="a_venir" {{ request()->get('status') == 'a_venir' ? 'selected' : '' }}>À venir</option>
                    <option value="en_cours" {{ request()->get('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="passe" {{ request()->get('status') == 'passe' ? 'selected' : '' }}>Passé</option>
                </select>



                <button type="submit" class="btn btn-primary ms-2">Rechercher</button>
            </form>

            @foreach ($hackathon as $h)
               
                <div class="d-flex align-items-center mb-2"> 
                     <p class="mb-0"><h3>{{ $h->thematique }}</h3> &nbsp; &nbsp; &nbsp; {{$h->dateheuredebuth}} / {{$h->dateheurefinh}}</p>
                     
                    <a href="/home/{{$h->idhackathon}}" class="btn bg-green m-2 button-home">Détail de l'hackathon</a>
                </div>
                
            @endforeach
        </div>

        
        <div class="d-flex justify-content-center mt-3">
            {{ $hackathon->links("pagination::bootstrap-5") }} 
        </div>
    </div>
</div>
@endsection



