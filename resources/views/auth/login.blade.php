@extends('layouts.app')
<link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}"/>
@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 5%">
            <div class="col-md-8">
                <div class="box">
                    <div id="header">
                        <div id="cont-lock">
                            <i class="material-icons lock">
                                OTOP PHUKET
                            </i>
                        </div>
                        <div id="bottom-head"><h1 id="logintoregister">Login</h1></div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="group">
                            <input id="email" type="email" class="inputMaterial{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>
                                {{ __('E-Mail Address') }}
                                @if ($errors->has('email'))
                                    <b style="color: red;">
                                        ( {{ $errors->first('email') }} )
                                    </b>
                                @endif
                            </label>
                        </div>
                        <div class="group">
                            <input id="password" class="inputMaterial{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  type="password" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>
                                {{ __('Password') }}
                                @if ($errors->has('password'))
                                    <b style="color: red;">
                                        ( {{ $errors->first('password') }} )
                                    </b>
                                @endif
                            </label>
                        </div>
                        <button id="buttonlogintoregister" type="submit">{{ __('Login') }}</button>
                    </form>

                    <div id="footer-box"><p class="footer-text">Not a member?<span class="sign-up"><a style="color: #fff;" href="{{ route('register') }}">Sign up now</a></span></p></div>
                </div>
            </div>
        </div>
    </div>
@endsection
