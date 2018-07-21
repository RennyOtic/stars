@extends('layouts.app')

@section('title', 'LogIn | ')

@section('end')
<body class="cover" style="background-image: url(./img/loginFont.jpg);">
    <div id="app">
        <form action="{{ route('login') }}" method="POST" class="full-box logInForm" autocomplete="off">

            {{-- <i class="zmdi zmdi-account-circle zmdi-hc-5x"></i> --}}
            <p class="text-center text-muted"><img src="{{ asset('./img/logo.jpeg') }}" alt="logo" width="270"></p>
            <p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>

            {{ csrf_field() }}
            <div class="form-group label-floating has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email" class="control-label">Correo:</label>
                <input id="email" type="email" class="form-control" name="email" value="root@smoothtalkers.com" required autofocus> 
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @else
                <p class="help-block">Escribe tu Correo</p>
                @endif
            </div>

            <div class="form-group label-floating has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password" class="control-label">Contraseña:</label>
                <input id="password" type="password" class="form-control" name="password" value="secret" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @else
                <p class="help-block">Escribe tu contraseña</p>
                @endif
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

        </form>
    </div>
</body>
@endsection
