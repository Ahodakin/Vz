@extends('layouts.frontend.simple')

@section("title")
www.monassurance.ci :: Soyez rassurés, tout est géré. 
@endsection

@section("custom-styles")
<style type="text/css">
    .input{
        margin-top:20px;
    }
</style>
@endsection

@section("custom-scripts")

@endsection

@section('content')
                    <div class="col-md-6" style="background:url('/images/manonpc.jpg') no-repeat center top;height:800px">
                    </div>
                    <div class="col-md-6" style="padding:15px">
                        <div class="text-center">
                        <a href="/"><img src="{{asset('images/logo.png')}}" alt=""></a>
                        <div class="form" style="margin-top:15px">
                            <h2>Connectez vous à votre espace</h2>

                            <form method="post" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <input type="text" placeholder="Adresse email" name="email" value="{{old('email')}}" class="input">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <input type="password" placeholder="Mot de passe" name="password" value="{{old('password')}}" class="input">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success" data-text="Valider">Valider</button>

                                <p style="margin-top:30px">Pas encore d'espace personnel? <a href="">Créer votre compte maintenant</a></p>

                                <p><a class="btn btn-link" href="{{ route('password.request') }}">
                                    Mot de passe oublié?
                                </a></p>
                            </form>
                        </div>
                        </div>
                    </div>
@endsection
