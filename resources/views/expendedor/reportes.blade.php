@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card card-default">
          <div class="card-header">Reportes</div>
          <div class="card-body">

            <form method="get" action="{{url('expendedor/reportes')}}">
              <input type="hidden" value="{{ Auth()->user()->estacion_id }}"  name="estacion_id"/>
              <div class="row">

                <div class="input-group-append col-md-3 mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-calendar-alt"></i>
                    </div>
                  </div>
                  <input type="date" name="fecha_desde" class="form-control" placeholder="Fecha Desde" value="{{request('fecha_desde')}}"/ required>
                  <input type="date" name="fecha_hasta" class="form-control" placeholder="Fecha Hasta" value="{{request('fecha_hasta')}}">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="excel" value="1" />
                    <input type="hidden" name="por_estaciones" value="1" />
                    <button type="submit" class="btn btn-success"> <i class="fas fa-file-excel"></i> Excel</button>
                    <a href="{{ url('expendedor/reportes') }}" class="btn btn-info"> <i class="fas fa-eraser"></i> Limpiar</a>
                </div>
              </div>
            </form>


          </div>
    </div>
</div>
</div>
@endsection
