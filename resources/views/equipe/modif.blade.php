@extends('layouts.app')

@section('title', ' - Login')

@section('custom-css')
    <link href="/css/login.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg fullContainer">

        <div style="box-shadow: 10px 5px 5px red; border-radius:10px;">
            <form action="/modifier" method="post" id="formContent">
                <form action="{{route("connect")}}">
                    @csrf
                    <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email"/>
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password"/>
                    <input type="submit" class="fadeIn fourth" value="Modifier mon équipe"/>
                    <br>
                </form>


            </form>
        </div>

    </div>
@endsection