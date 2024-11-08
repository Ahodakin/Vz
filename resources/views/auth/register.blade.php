@extends('layouts.frontend.simple')

@section("title")
monassurance.ci ::Automobile | Soyez rassurer, on gère.
@endsection

@section("custom-styles")
<style type="text/css">
    .input{
        margin-top:20px;
    }
</style>
@endsection

@section("custom-scripts")
<script>
    $(document).ready(function() {
        $("#phone").mask("99 99 99 99 99");
    })
</script>
@endsection

@section('content')
    <div class="col-md-6" style="background:url('/images/manonpc.jpg') no-repeat center top;height:800px">
    </div>
    <div class="col-md-6" style="padding:15px">
        <div class="text-center">
        <a href="/"><img src="{{asset('images/logo.png')}}" alt=""></a>
        <div class="form" style="margin-top:15px">
            <h2>Créer votre espace maintenant</h2>

            <form method="post" action="{{ route('register') }}">
                {{ csrf_field() }}
                @if(Session::has('_userid_'))
                <input type="hidden" name="uid" value="{{Session::get('_userid_')}}">
                <script>
                window.onload = function() {
                    document.getElementById("password").focus();
                };
                </script>
                @endif
                <input type="text" placeholder="Nom" class="input" autofocus name="lastname" value="{{(Session::has('_lastname_'))? Session::get('_lastname_') : old('lastname')}}">
                @if ($errors->has('lastname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                @endif
                <input type="text" placeholder="Prénom" name="firstname" value="{{(Session::has('_firstname_'))? Session::get('_firstname_') : old('firstname')}}" class="input">
                @if ($errors->has('firstname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('firstname') }}</strong>
                    </span>
                @endif
                <input type="text" placeholder="Adresse email" name="email" value="{{(Session::has('_email_'))? Session::get('_email_') :old('email')}}" class="input" {{(Session::has('_email_')) ? 'readonly' : '' }}>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="text" placeholder="Numero de téléphone" name="phone" id="phone" value="{{(Session::has('_contact_'))? Session::get('_contact_') : old('phone')}}" class="input">
                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
                <input type="password" placeholder="Mot de passe" name="password" id="password" value="{{old('password')}}" class="input">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit" class="btn btn-success" data-text="Valider">Valider</button>

                <p style="margin-top:30px">Déja un espace personnel? <a href="/login">Connectez vous pour y acceder</a></p>
            </form>
        </div>
        </div>
    </div>
@endsection
