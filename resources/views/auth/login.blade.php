@extends('layouts.frontend.simple')

@section("title")
www.monassurance.ci :: Connectez vous à votre espace personnel.
@endsection

@section("custom-styles")
<style type="text/css">
    .input{
        margin-top:20px;
    }
</style>
@endsection

@section("custom-scripts")
<script type="text/javascript">
$(document).ready(function() {

    $("#phone_number").mask("99 99 99 99 99");
    window.onload = function() {
      var input = document.getElementById("phone_number").focus();
    }
});
</script>
@endsection

@section('content')
    <div class="col-md-6 hidden-xs" style="background:url('/images/manonpc.jpg') no-repeat center top;height:800px">
    </div>
    <div class="col-md-6" style="padding:15px">
        <div class="text-center">
        <a href="/"><img src="{{asset('images/logo.png')}}" alt=""></a>
        <div class="form" style="margin-top:15px">
            <h2>Connectez vous à votre espace</h2>

            @if(\Illuminate\Support\Facades\Session::has('error'))
                <br/>
                <div class="alert alert-danger alert-dismissable">
                    <p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p>
                </div>
            @endif
            @if(\Illuminate\Support\Facades\Session::has('success'))
                <br/>
                <div class="alert alert-success alert-dismissable">
                    <p align="center">{{\Illuminate\Support\Facades\Session::get('success')}}</p>
                </div>
            @endif

            <form method="post" action="{{ route('login') }}">
                {{ csrf_field() }}

                <input type="text" required placeholder="N° de téléphone" id="phone_number" name="phone_number" value="{{old('phone_number')}}" class="input">
                @if ($errors->has('phone_number'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone_number') }}</strong>
                    </span>
                @endif
                <input type="password" placeholder="Mot de passe" name="password" value="{{old('password')}}" required class="input">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit" class="btn btn-success" data-text="Connectez-vous">Connectez-vous</button>

                <p style="margin-top:30px">Pas encore d'espace personnel?<br> Un espace vous sera créé à votre prochaine comparaison<br>
                <a href="{{route('page.quote.auto')}}">AUTO</a> ,<a href="{{route('page.quote.moto')}}">MOTO</a> ou <a href="{{route('page.quote.voyage')}}">VOYAGE</a>
                </p>

                <p><a class="btn btn-link" data-text="Recuperer votre mot de passe" href="{{ route('password.request') }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;Mot de passe oublié?&nbsp;&nbsp;&nbsp;&nbsp;
                </a></p>
            </form>
        </div>
        </div>
    </div>
@endsection
