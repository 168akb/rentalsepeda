@extends('layouts.auth')

@section('title','Login | Rental Sepeda Rysafi')

@section('content')


<!-- Login Register area Start-->
    <div class="login-content">
        <!-- Login -->
        <div class="nk-block toggled" id="l-login">
            <div class="nk-form" style="border-radius: 10px;">
                <form method="POST" action="{{ route('login') }}">
                @csrf
                <h3>Log in</h3>                            
                <div class="input-group">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                    <div class="nk-int-st">
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Username">
                    </div>
                </div>
                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <div class="input-group mg-t-15">
                    <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                    <div class="nk-int-st">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                    </div>
                </div>
                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                <br>
                    <button type="submit" class="btn btn-success notika-btn-success btn-block" style="border-radius: 25px">Login</button>
                    <p style="padding-top: 10px;">Atau</p>
                    <a class="btn btn-link" href="{{ url('/guest') }}">Masuk sebagai Guest</a>
            </div>
            <div class="nk-navigation nk-lg-ic">
                <a href="{{ route('register') }}" data-ma-block="#l-register"><i class="notika-icon notika-plus-symbol"></i> <span>Register</span></a>
            </div>
        </div>

@endsection