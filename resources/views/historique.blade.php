@extends('layouts.app')

@section('custom-css')
    <link href="/css/home.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
    <div class="card w-50 cardRadius">
        <div>
            <h3>Hackathon Entries</h3>
            @foreach ($hackathon as $h)
                <p>{{ $h->thematique }}</p>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $hackathon->links() }} 
        </div>
    </div>
</div>
@endsection


