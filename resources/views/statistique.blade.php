@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
        <div class="wrapper fadeInDown">
            <div class="container">
                <h2 class="text-center mb-4">Statistiques des Hackathons</h2>
                <br>
                <br>
                <h4 class="text-center mb-4">Nombre d'hackathon par mois</h4>

                <form method="GET" action="{{ route('statistique') }}" class="mb-4">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <select id="year" name="year" class="form-select">
                                <option value="">Toutes les années</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" 
                                            {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Nombre de Hackathons</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($hackathons as $hackathon)
                                <tr>
                                    <td>{{ \Carbon\Carbon::create()->month($hackathon->month)->translatedFormat('F') }}</td>
                                    <td>{{ $hackathon->year }}</td>
                                    <td>{{ $hackathon->count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Aucun hackathon trouvé pour l'année sélectionnée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
