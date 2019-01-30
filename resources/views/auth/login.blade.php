@extends('layouts.app')

@section('title', 'LogIn | ')

@section('end')
<body class="cover" style="background-image: url(./img/loginFont.jpg);">
    <div id="app">
        <form action="{{ route('login') }}" method="POST" class="full-box logInForm" autocomplete="off">

            <p class="text-center text-muted"><img src="{{ asset('./img/logo.jpeg') }}" alt="logo" width="270"></p>
            @if ($errors->has('email'))
            <p class="alert alert-danger">
                <strong>{{ $errors->first('email') }}</strong>
                @if ($errors->has('password'))
                <strong>{{ $errors->first('password') }}</strong>
                @endif
            </p>
            @endif
            <p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>

            {{ csrf_field() }}
            <div class="form-group label-floating has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email" class="control-label">Correo:</label>
                @if(env('APP_ENV') == 'local')
                <input id="email" type="email" class="form-control" name="email" value="root@smoothtalkers.com" required autofocus> 
                @else
                <input id="email" type="email" class="form-control" name="email" value="" required autofocus> 
                @endif
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group label-floating has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password" class="control-label">Contraseña:</label>
                @if(env('APP_ENV') == 'local')
                <input id="password" type="password" class="form-control" name="password" value="secret" required>
                @else
                <input id="password" type="password" class="form-control" name="password" value="" required>
                @endif
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-5">
                    <div class="checkbox icheck">
                        <label class="control control--checkbox">
                            <input id="checkboxRemenber" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <div class="control__indicator"></div>
                        </label>
                        <label for="checkboxRemenber" class="remenber">Recuérdame</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <button type="submit" class="btn btn-raised btn-danger">Iniciar sesión</button>
                </div>
            </div>

            @if(config('frontend.registration_open'))
            <a href="{{ route('register') }}">Registra nueva membresía.</a>
            @endif
            <a href="{{ route('password.request') }}">Recuperar Contraseña.</a>

        </form>
    </div>
</body>
@endsection
