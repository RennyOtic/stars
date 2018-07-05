@extends('layouts.app')

@section('title', 'Login | ')

@section('end')
<body class="hold-transition login-page layout-top-nav">
    <div id="app" class="wrapper">
        <div class="login-box">
            <div class="login-logo">
                {!! config('frontend.logo_lg') !!}
            </div>
            {{-- /.login-logo --}}
            <div class="login-box-body">
                <p class="login-box-msg">Ingresa para comenzar tu sesión.</p>

                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email" class="control-label">Correo:</label>
                        <input id="email" type="email" class="form-control" name="email"  placeholder="Email" value="root@smoothtalkers.com" required autofocus> {{-- {{ old('email') }} --}}
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} has-feedback">
                        <label for="password" class="control-label">Contraseña:</label>
                        <input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" value="secret" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label class="control control--checkbox">
                                    <input id="checkboxRemenber" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <div class="control__indicator"></div>
                                </label>
                                 <label for="checkboxRemenber" class="remenber">Recuérdame</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                        </div>
                    </div>
                </form>

{{--                 <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                    Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                    Google+</a>
                </div>
                <!-- /.social-auth-links --> --}}

                {{-- <a class="btn btn-link" href="{{ route('password.request') }}"> Forgot Your Password? </a> --}}
                {{-- <a href="#">Olvidé mi contraseña.</a><br> --}}
                @if(config('frontend.registration_open'))
                <a href="{{ route('register') }}">Registra nueva membresía.</a>
                @endif

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>
</body>
@endsection
