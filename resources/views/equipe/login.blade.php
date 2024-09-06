@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">

        <div class="wrapper fadeInDown">
            <form action="/login" method="post" id="formContent">
                <!-- Icon -->
                <div class="fadeIn first">
                    <img src="/img/user.png" class="icon" id="icon" alt="User Icon"/>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mx-3 first">
                        <ul class="list-unstyled m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{route("connect")}}">
                    @csrf
                    <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email"/>
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password"/>
                    <input type="submit" class="fadeIn fourth" value="Connexion"/>

                    <a href="{{ route("create-team") }}" class="fadeIn fourth d-block p-2 text-black">Créer une équipe</a>
                </form>


            </form>
        </div>

    </div>
@endsection
