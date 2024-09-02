@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Registro Consumo. Paso 3/3</div>

                <div class="card-body">

                  <form method="post" action="{{ url('consumo/grabar',[$id,$monto]) }}" aria-label="{{ __('validar') }}" onsubmit="return checkSubmit();">
                    @csrf

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <label for="monto">Monto Consumido:</label>
                        <label type="text" name="monto" id="monto" class="form-control" > {{ $monto }} </label>
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <label for="pin">PIN de Seguridad:</label>
                        <input type="password" name="pin" id="pin" class="form-control{{ $errors->has('pin') ? ' is-invalid' : '' }}" required/>

                        @if ($errors->has('pin'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pin') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                          &nbsp;
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                          <button type="submit" id="btsubmit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-save"></i> {{ __('Registrar') }}
                          </button>
                      </div>

                    </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("js")
<script type="application/javascript">
    function checkSubmit() {
        var btn = document.getElementById("btsubmit");
        btn.innerHTML = "Procesando...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }
</script>
@endsection