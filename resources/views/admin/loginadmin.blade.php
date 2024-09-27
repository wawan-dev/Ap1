@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">

        <div class="wrapper fadeInDown">
            <form action="/loginAdmin" method="post" id="formContent">

            <h2 class="justify-content-center p-4">Formulaire Administrateur</h2>

                @if ($errors->any())
                    <div class="alert alert-danger mx-3 first">
                        <ul class="list-unstyled m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email"/>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password"/>
                <input type="submit" class="fadeIn fourth" value="Connexion Admin"/>
            </form>
        </div>

    </div>
@endsection
