@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Registro Consumo. Paso 1/3</div>

                <div class="card-body">
                  @empty($usuario)
                    <form method="get" action="{{ url('consumo') }}" aria-label="{{ __('Registro Consumo') }}">

                        <div class="row  justify-content-center">
                            <label for="name" class="col-form-label">{{ __('DNI') }}</label>

                            <div class="col-md-6" >
                                  <input id="dni" type="text" class="form-control{{ $errors->has('dni') ? ' is-invalid' : '' }}" name="dni" value="{{ old('dni') }}" required autofocus>

                                @if ($errors->has('dni'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dni') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary  btn-lg btn-block">
                                  <i class="fas fa-search"></i> {{ __('Continuar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                  @endempty

                  @if( empty($usuario->dni) && !empty(request('dni')) )
                    <p class="label label-warning">
                      Usuario no encontrado.
                    </p>
                  @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
