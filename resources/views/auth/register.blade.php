@extends('layouts.app')

@section('title', 'Registro | ')

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

                <form method="POST" action="{{ url('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name" class="control-label">Nombre:</label>
                                <input id="name" type="text" class="form-control" name="name"  placeholder="Nombre" value="{{ old('name') }}" required autofocus>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <label for="last_name" class="control-label">Apellido:</label>
                                <input id="last_name" type="text" class="form-control" name="last_name"  placeholder="Apellido" value="{{ old('last_name') }}" required>
                                <span class="fa fa-user-o form-control-feedback"></span>
                                @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('num_id') ? 'has-error' : '' }}">
                                <label for="num_id" class="control-label">Cédula:</label>
                                <input id="num_id" type="text" class="form-control" name="num_id"  placeholder="######" value="{{ old('num_id') }}" required>
                                <span class="fa fa-id-card-o form-control-feedback"></span>
                                @if ($errors->has('num_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('num_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail:</label>
                                <input id="email" type="text" class="form-control" name="email"  placeholder="E-Mail" value="{{ old('email') }}" required>
                                <span class="fa fa-envelope form-control-feedback"></span>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password" class="control-label">Contraseña:</label>
                                <input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" required>
                                <span class="fa fa-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <label for="password_confirmation" class="control-label">Confirmación:</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  placeholder="Confirmación" required>
                                <span class="fa fa-lock form-control-feedback"></span>
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-xs-4 col-md-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>
</body>
@endsection