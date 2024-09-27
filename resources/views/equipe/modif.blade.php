@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')


    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg" >
        
        <div >
            <form action="/modif_equipe/{{$connected->idequipe}}" method="post" id="formContent" style="box-shadow: 10px 5px 5px black; border-radius:10px;">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled text-start m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h2 class="justify-content-center p-4">Modifier mon équipe</h2>
                @csrf
                <input type="text" id="name" class="fadeIn second" name="name" placeholder="Name" value="{{$connected->nomequipe}}"/>
                <input type="email" id="login" class="fadeIn second" name="email" placeholder="Email" value="{{$connected->login}}"/>
                <input type="password" id="NewPassword" class="fadeIn third" name="NewPassword" placeholder="NewPassword"/>
                <input type="password" id="VerifyNewPassword" class="fadeIn third" name="VerifyNewPassword" placeholder="VerifyNewPassword"/>
                <input type="submit" class="fadeIn fourth" value="Modifier mon équipe"/>
                <br>
            </form>
        </div>

    </div>
@endsection