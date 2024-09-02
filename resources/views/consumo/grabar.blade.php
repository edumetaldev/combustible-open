@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header text-white bg-success">¡Consumo registrado con exito!</div>

                <div class="card-body">



                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <label for="consumidor">Consumidor:</label>
                        <label class="form-control">{{ $consumidor }}</label>
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <label for="monto">Monto Consumido:</label>
                        <label class="form-control">{{ $monto }}</label>
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <label for="expendedor">Expendedor:</label>
                        <label class="form-control">{{ $expendedor }}</label>
                                            </div>
                      </div>

                      <div class="row justify-content-center">
                        <div class="col-md-8">
                          <label for="expendedor">Estación:</label>
                          <label class="form-control">{{ $estacion }}</label>
                                                </div>
                      </div>

                      <div class="row justify-content-center">
                        <div class="col-md-8">
                          <label for="expendedor">Fecha / Hora:</label>
                          <label class="form-control">{{ $fecha }}</label>
                                                </div>
                      </div>


                    <div class="row justify-content-center">
                      <div class="col-md-8">
                          &nbsp;
                      </div>
                    </div>

                    <div class="row justify-content-center">
                      <div class="col-md-8">
                          <a href="{{ url('consumo') }}" type="button" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-back"></i> {{ __('Volver') }}
                          </a>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
