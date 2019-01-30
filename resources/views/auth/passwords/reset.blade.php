@extends('layouts.app')

@section('title', 'Restablecer la contraseña | ')

@section('end')
<body class="cover" style="background-image: url(/img/loginFont.jpg);">
    <div id="app">
        <form action="{{ route('password.request') }}" method="POST" class="full-box logInForm" autocomplete="off">

            <p class="text-center text-muted"><img src="{{ asset('./img/logo.jpeg') }}" alt="logo" width="270"></p>
            <p class="text-center text-muted text-uppercase">Restablecer la contraseña</p>

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group label-floating has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email" class="control-label">Correo:</label>
                <input id="email" type="email" class="form-control" name="email" value="" required autofocus> 
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group label-floating has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password" class="control-label">Nueva Contraseña:</label>
                <input id="password" type="password" class="form-control" name="password" value="" required autofocus> 
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group label-floating has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <label for="password_confirmation" class="control-label">Repita Contraseña:</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="" required autofocus> 
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>

            <div class="row">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-raised">
                        Restablecer Contraseña
                    </button>
                </div>
            </div>

            <a href="{{ url('/') }}">Inicia Sesión.</a>

        </form>
    </div>
</body>
@endsection
