@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg ">
        <div class="wrapper fadeInDown">
            <div class="container">
                <h2 class="text-center mb-4">Statistiques des Hackathons</h2>
                <br>
                <br>
                

                

                <div class="row">
                    
                    <div class="col-md-6">
                    <div style="background-color: rgba(128, 128, 128, 0.8); padding:20px; border-radius: 20px;">
                    <h4 class="text-center mb-4">Nombre d'hackathon par mois</h4>
                    <form method="GET" action="{{ route('statistique') }}" class="mb-4">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                
                                <select id="year" name="year" class="form-select">
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
                            <table class="table table-sm table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>Mois</th>
                                        <th>Année</th>
                                        <th>Nombre de Hackathons</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($hackathonsByMonth as $month => $hackathon)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</td>
                                            <td>{{ $selectedYear }}</td>
                                            <td>{{ $hackathon->count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                    <!-- Tableau à droite (vide pour l'instant) -->
                    <div class="col-md-6">
                        <div style="background-color: rgba(128, 128, 128, 0.7); padding:20px; border-radius: 20px;">
                            <h4 class="text-center mb-4">Nombre de connexion les 5 derniers jours</h4>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                                    <thead class="table-primary text-center">
                                        <tr>
                                            <th>Date</th>
                                            <th>Nombre de connexion</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($visits as $visit)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($visit->day)->translatedFormat('d F Y') }}</td>
                                                <td>{{ $visit->visits }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div style="background-color: rgba(128, 128, 128, 0.8); padding:20px; border-radius: 20px;">
                            <h4 class="text-center mb-4">Nombre d'équipe et membre sur Hackat'innov</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                                    <thead class="table-primary text-center">
                                        <tr>
                                            <th> </th>
                                            <th> </th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        
                                            <tr>
                                                <td>Nombre d'équipe</td>
                                                <td>{{ $nbequipe }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nombre de membre</td>
                                                <td>{{ $nbmembre }}</td>
                                            </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background-color: rgba(128, 128, 128, 0.7); padding:20px; margin:20px; border-radius: 20px;">
                        <form method="GET" action="{{ route('statistique') }}">
                            <label for="ville">Filtrer par ville :</label>
                            <select name="ville" id="ville" onchange="this.form.submit()">
                                <option value="">Toutes les villes</option>
                                @foreach($hackathonsByVille as $hackathon)
                                    <option value="{{ $hackathon->ville }}" {{ $hackathon->ville == $selectedVille ? 'selected' : '' }}>
                                        {{ $hackathon->ville }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <h3>Nombre de hackathons par ville :</h3>
                        <table class="table table-sm table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Ville</th>
                                    <th>Nombre de Hackathons</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($hackathonsByVille as $hackathon)
                                    <tr>
                                        <td>{{ $hackathon->ville }}</td>
                                        <td>{{ $hackathon->count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
@endsection
