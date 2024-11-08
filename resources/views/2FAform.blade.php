@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">
        <div class="wrapper fadeInDown ">
            <form action="{{ route('code_2FA') }}" method="POST" id="formContent">
                @csrf
                <h1>Double Authentification</h1>
                @if ($errors->any())
                    <div class="alert alert-danger mx-3 first">
                        <ul class="list-unstyled m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                
                <input type="text" id="2FA" class="fadeIn second" name="2FA" placeholder="Code authentificator" required/>

                <button type="submit" class="btn btn-primary mt-3 fadeIn third m-5">Vérifier</button>
            </form>
        </div>
    </div>
@endsection
