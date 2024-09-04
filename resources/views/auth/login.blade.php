@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Acceso') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Acceso') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="dni"
                                    class="col-sm-4 col-form-label text-md-right">{{ __('DNI') }}</label>

                                <div class="col-md-6">
                                    <input id="dni" type="dni"
                                        class="form-control{{ $errors->has('dni') ? ' is-invalid' : '' }}" name="dni"
                                        value="{{ old('dni') }}" required autofocus>

                                    @if ($errors->has('dni'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dni') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Acceder') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Acceso') }}">
                            @csrf
                            <input type="hidden" name="dni" value="12345678">
                            <input type="hidden" name="password" value="123456">
                            <div class="form-group row my-2">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-secondary">
                                        {{ __('Acceder como Administrador') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Acceso') }}">
                            @csrf
                            <input type="hidden" name="dni" value="88888888">
                            <input type="hidden" name="password" value="123456">
                            <div class="form-group row my-2">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-default">
                                        {{ __('Acceder como Expendedor') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Acceso') }}">
                            @csrf
                            <input type="hidden" name="dni" value="77777777">
                            <input type="hidden" name="password" value="123456">
                            <div class="form-group row my-2">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-warning">
                                        {{ __('Acceder como Visor de Cuentas') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <a href="{{ url('instalar') }}" class="btn btn-success">Instalación Mobil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
