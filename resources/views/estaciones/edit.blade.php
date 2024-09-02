@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Actualizar Estacion') }}</div>

                <div class="card-body">
                  <form action="{!! route('estaciones.update',[$estacion->id]) !!}" method="post">
                        @method('PATCH')
                        @csrf
                        @include('estaciones.fields')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                  <i class="fas fa-save"></i> {{ __('Actualizar') }}
                                </button>
                                <a href="{{ url('estaciones') }}" class="btn btn-primary"> <i class="far fa-arrow-alt-circle-left"></i> Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
