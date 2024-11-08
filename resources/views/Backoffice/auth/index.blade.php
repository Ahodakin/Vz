@extends('Backoffice.auth.app')

@section("content")
<div id="wrap" class="animsition">




    <div class="page page-core page-login">

        <div class="text-center"><h3 class="text-light text-white">
            <span class="text-lightred">MON</span>ASSURANCE.CI</h3></div>
            <div class="text-center container w-420">
                @if(\Illuminate\Support\Facades\Session::has('error'))
                    <br/>
                    <div class="alert alert-danger alert-dismissable">
                        <p align="center">{{ \Illuminate\Support\Facades\Session::get('error') }}</p>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <br/>
                    <div class="alert alert-success alert-dismissable">
                        <p align="center">{{ \Illuminate\Support\Facades\Session::get('success') }}</p>
                    </div>
                @endif
            
            </div>

        <div class="container w-420 p-15 bg-white mt-40 text-center">

                <div class="text-center">
                    <div class="logo"> <a href="/"><img src="{{asset('images/logo-1.png')}}" alt=""></a> </div>
                </div>

            <h2 class="text-light text-greensea">Connectez vous</h2>
            <form name="form" class="form-validation mt-20" method="post" action="{{ route('PostLogin') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" name="email" class="form-control underline-input" value="{{ old('email') }}" required placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" name="password" placeholder="Password" class="form-control underline-input">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group text-left mt-20">
                    <button type="submit" class="btn btn-greensea b-0 br-2 mr-5">Connexion</button>
                    <label class="checkbox checkbox-custom-alt checkbox-custom-sm inline-block">
                        <input type="checkbox" value="1" name="remember" {{ old('remember') ? 'checked' : '' }}><i></i> Se souvenir de moi
                    </label>
                    <!-- <a href="#" class="pull-right mt-10">Mot de passe oublié?</a> -->
                </div>

            </form>
            <hr class="b-3x">
        </div>
    </div>
</div>
@endsection
