@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inicio Cuenta Corriente') }}</div>

                <div class="card-body">
                  <form action="{!! route('cuentacorriente.store') !!}" method="post">
                        @csrf
<!-- -->            <input type="hidden" name="tipo_movimiento" value="deposito"/>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Cuenta Origen') }}</label>

                        <div class="col-md-6">
                            <select name="cuenta_origen_id" class="form-control" autofocus required>
                              <option value="">
                                Seleccione cuenta
                              </option>
                              @forelse ($cuentas as $cuenta)
                                  <option value="{{ $cuenta->id }}" {{ old('cuenta_origen_id') == $cuenta->id ? 'selected': ''}}>
                                    {{ $cuenta->nombre }}
                                  </option>
                              @empty
                                  <option value ="">
                                    No hay cuentas
                                  </option>
                              @endforelse
                            </select>
                            @if ($errors->has('cuenta_origen_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cuenta_origen_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Monto') }}</label>

                        <div class="col-md-6">
                          <div class="input-group-append">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                $
                              </div>
                            </div>
                            <input id="monto" min="0" step=".01" type="number" class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}" name="monto" value="{{ old('montod') }}" required autofocus>
                          </div>

                            @if ($errors->has('monto'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('monto') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                      @include('components.field_comentarios')
                    </div>


<!-- -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                              <i class="fas fa-save"></i> {{ __('Grabar') }}
                            </button>
                            <a href="{{ url('cuentacorriente') }}" class="btn btn-primary"> <i class="far fa-arrow-alt-circle-left"></i> Volver</a>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
