@extends('layouts.frontend.simple')

@section("title")
www.monassurance.ci :: Réinitialiser votre mot de passe
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
     $("#phone").mask("99 99 99 99 99");
    $("#pin").mask("9 9 9 9");
    window.onload = function() {
      var input = document.getElementById("pin").focus();
    }
});
</script>
@endsection

@section('content')
    <div class="col-md-6" style="background:url('/images/manonpc.jpg') no-repeat center top;height:800px">
    </div>
    <div class="col-md-6" style="padding:15px">
        <div class="text-center">
        <a href="/"><img src="{{asset('images/logo.png')}}" alt=""></a>
        <div class="form" style="margin-top:15px">
            <h2>Changer votre mot de passe </h2>
                @if(Session::has('info'))
                <br/>
                <div class="alert alert-info alert-dismissable">
                    <p align="center">{{Session::get('info')}}</p>
                </div>
            @endif
            @if(Session::has('error'))
                <br/>
                <div class="alert alert-danger alert-dismissable">
                    <p align="center">{{Session::get('error')}}</p>
                </div>
            @endif

            <form method="post" action="{{ route('reset.updatepassword') }}">
                {{ csrf_field() }}

                <input type="text" placeholder="Votre contact" required name="phone"  id="phone" class="input" readonly value="{{ $account->phone_number }}">

                    <input type="password" placeholder="Nouveau mot de passe" required name="newpassword"  id="newpassword" class="input">
                    <input type="password" placeholder="Ressaissir le mot de passe" required name="repeatnewpassword"  id="repeatnewpassword" class="input">
                <button type="submit" class="btn btn-success" data-text="Valider">Valider</button>


            </form>
        </div>
        </div>
    </div>
@endsection
