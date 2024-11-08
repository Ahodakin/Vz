@extends('Backoffice.auth.app')

@section("content")
    <div class="page page-core page-locked">

                <div class="text-center"><h3 class="text-light text-white"><span class="text-lightred">MONASSURANCE</span>.CI</h3></div>

                <div class="text-center container w-420">
                    @if(\Illuminate\Support\Facades\Session::has('warning'))
                        <br/>
                        <div class="alert alert-danger alert-dismissable">
                            <p align="center">{{ \Illuminate\Support\Facades\Session::get('warning') }}</p>
                        </div>
                    @endif
                    @if(\Illuminate\Support\Facades\Session::has('error'))
                        <br/>
                        <div class="alert alert-success alert-dismissable">
                            <p align="center">{{ \Illuminate\Support\Facades\Session::get('error') }}</p>
                        </div>
                    @endif
                
                </div>

        <div class="container w-420 p-15 bg-white mt-40">

            <div class="bg-slategray lt wrap-reset mb-20 text-center">
                <h2 class="text-light text-greensea m-0">Locked</h2>
            </div>

            @if(\Illuminate\Support\Facades\Session::has('_email'))
            <div class="pull-left thumb thumb-lg mr-20" style="width: 90px; border-radius: 30%;">
                <img class="media-object img-circle" src="/back/assets/uploads/avatar/{{ \Illuminate\Support\Facades\Session::get('_avatar') }}" alt="">
            </div>
            <div class="media-body">
                <form name="form" class="form-validation" method="POST" action="{{ route('PostSpaceLocked') }}">
                    {{ csrf_field() }}
                    <h4 class="media-heading mb-0">
                        <input type="hidden" value="{{ \Illuminate\Support\Facades\Session::get('_email') }}" readonly>
                        {{ \Illuminate\Support\Facades\Session::get('_firstname') }} <strong>{{ \Illuminate\Support\Facades\Session::get('_lastname') }}</strong>
                    </h4>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mt-10">
                        <input type="password" required placeholder="Password" name="password" class="form-control underline-input">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group text-left">
                        <button type="submit" class="btn btn-greensea b-0 br-2 mr-5 block">Reconnectez vous</button>
                    </div>
                </form>             
            </div>
            @else
                <div class="alert alert-danger alert-dismissable">
                    <p align="center">Une erreur s'est produite!!</p>
                </div>
            @endif
            

            <div class="bg-slategray lt wrap-reset mt-0 text-center">
                <p class="m-0">
                    <a href="{{route('loginform')}}">Ce n'est pas moi?</a>
                </p>
            </div>
        </div>
    </div>
@endsection