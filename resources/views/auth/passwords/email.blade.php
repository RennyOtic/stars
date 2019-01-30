@extends('layouts.app')

@section('title', 'Se te olvidó tu contraseña | ')

@section('end')
<body class="cover" style="background-image: url(/img/loginFont.jpg);">
    <div id="app">
        <form action="{{ route('password.email') }}" method="POST" class="full-box logInForm" autocomplete="off">

            <p class="text-center text-muted"><img src="{{ asset('./img/logo.jpeg') }}" alt="logo" width="270"></p>
            @if ($errors->has('email'))
            <p class="alert alert-danger">
                <strong>{{ $errors->first('email') }}</strong>
                @if ($errors->has('password'))
                <strong>{{ $errors->first('password') }}</strong>
                @endif
            </p>
            @endif
            <p class="text-center text-muted text-uppercase">¿Se te olvidó tu contraseña?</p>

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            {{ csrf_field() }}

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


            <div class="row">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-raised">
                        Enviar Enlace para Restablecer
                    </button>
                </div>
            </div>

            <a href="{{ url('/') }}">Inicia Sesión.</a>

        </form>
    </div>
</body>
@endsection
