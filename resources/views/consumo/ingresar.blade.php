@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Registro Consumo. Paso 2/3</div>

                <div class="card-body">

                  @isset($usuario)
                  <form method="post" action="{{ url('consumo/validar',$usuario->id) }}" aria-label="{{ __('validar') }}">
                    @csrf
                    <div class="row justify-content-center">
                      <div class="col-md-8" >

                        <h4>{{ $usuario->nombre }}</h4>
                        <h5>Dni: {{ $usuario->dni }}</h5>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <label for="monto">Monto Consumido:</label>
                    </div>

                    <div class="row justify-content-center">
                      <div class="input-group-append col-md-8">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            $
                          </div>
                        </div>
                        <input type="number" min="0" step=".01" name="monto" id="monto" class="form-control{{ $errors->has('saldo') ? ' is-invalid' : '' }}" value="{{ old('monto') }}" required>
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-6">
                        @if ($errors->has('saldo'))
                            <strong class="text-danger font-weight-bold">{{ $errors->first('saldo') }}</strong>
                        @endif

                        @if ($errors->has('bloqueo_consumo'))
                            <strong class="text-danger text-warning">{{ $errors->first('bloqueo_consumo') }}</strong>
                        @endif
                      </div>
                    </div>

                    <div class="row center">
                      <div class="col-md-12">
                          &nbsp;
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-md-8">
                          <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-save"></i> {{ __('Continuar') }}
                          </button>
                      </div>
                    </div>
                  </form>
                  @endisset
                </div>
            </div>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6"></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="card">
              <div class="card-body justify-content-center">
                <h2 class="text-center text-primary">Saldo: ${{$saldo}} </h2>
              </div>
          </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Últimos Consumos de: {{ $usuario->nombre }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                        <div class="table-responsive">
                            <table class="table table-striped table-condensed">
                                <tbody>
                                @foreach( $consumos as $consumo)
                                    <tr>
                                        <td><p>
                                            {{  $consumo->fecha}}</p>
                                            <small><strong>Exp:</strong> {{ $consumo->expendedor }}</small>
                                        </td>
                                        <td><h5>${{ abs($consumo->monto) }}</h5>
                                        @if ($consumo->tipo_movimiento == 'anulacion')
                                            <small> {{ $consumo->comentarios }} </small>
                                        @endif
                                        </td>
                                        <td>
                                            @if ($consumo->tipo_movimiento == 'consumo')
                                              @php
                                                $es_de_hoy = (Carbon\Carbon::now()->format('d-m-Y') == Carbon\Carbon::parse($consumo->fecha)->format('d-m-Y'))
                                              @endphp
                                              @if (!isset($consumo->cuenta_id_anulacion))
                                                @if ($es_de_hoy)
                                                  <form action="{{ route('consumo.destroy',$consumo->consumo_id) }}" method="post">
                                                      @csrf
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <button type="submit" onclick="return confirm('Confirme la anulación: \n Consumo de ${{ abs($consumo->monto) }} del {{ $consumo->fecha }}') " class="btn btn-danger btn-xs"><i class="fa fa-times" aria-hidden="true"></i></button>

                                                  </form>
                                                @endif
                                              @else
                                                      <strong><small>Anulado</small></strong>
                                              @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
