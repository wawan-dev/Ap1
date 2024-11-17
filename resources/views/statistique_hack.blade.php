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
            
                <div style="background-color: rgba(128, 128, 128, 0.8); padding:20px; border-radius: 20px;">
                <h4 class="text-center mb-4">Statistique générale de l'hackathon : {{$hackathon->thematique}}</h4>
                
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered shadow-sm rounded-3 overflow-hidden">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                
                                    <tr>
                                        <td>Nombre Maximum d'equipe</td>
                                        <td>{{$hackathon->nbplaceeqmax}}</td>                                        
                                    </tr>
                                    <tr>
                                        <td>Nombre de place restante</td>
                                        <td>{{$hackathon->nbplaceeqmax - $nb_equipe}}</td>                                        
                                    </tr>
                                    <tr>
                                        <td>Nombre d'équipe inscrite</td>
                                        <td>{{$nb_equipe}}</td>                                        
                                    </tr>
                                    <tr>
                                        <td>Nombre d'équipe désinscrite</td>
                                        <td>{{$nb_equipedes}}</td>                                        
                                    </tr>
                                    <tr>
                                        <td>Nombre de membre dans l'hackathon</td>
                                        <td>{{$nb_membre}}</td>                                        
                                    </tr>
                                    
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
@endsection