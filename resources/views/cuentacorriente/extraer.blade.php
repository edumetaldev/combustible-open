@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Extracción') }}</div>

                <div class="card-body">
                  <form action="{!! route('cuentacorriente.store') !!}" method="post">
                        @csrf
<!-- -->            <input type="hidden" name="tipo_movimiento" value="extraccion"/>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Cuenta Origen') }}</label>

                        <div class="col-md-6">
                            <input id="cuenta_origen_id" type="hidden" name="cuenta_origen_id" value="{{ old('cuenta_origen_id',$id) }}">
                            <label class="form-control">{{ $nombre }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Monto') }}</label>

                        <div class="col-md-6">
                            <input id="monto" min="0" step=".01" type="number" class="form-control{{ $errors->has('monto') || $errors->first('saldo')  ? ' is-invalid' : '' }}" name="monto" value="{{ old('monto') }}" required autofocus>

                            @if ($errors->has('monto'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('monto') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('saldo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('saldo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                      @include('components.field_comentarios')
                    </div>

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
