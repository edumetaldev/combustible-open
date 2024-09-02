<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
              <div class="card-header">Estaciones</div>
              <div class="card-body">

                @if (session('delete_ok'))
                  <div class="alert alert-success">
                      {{ session('delete_ok') }}
                  </div>
                @endif

                @if (session('delete_fail'))
                  <div class="alert alert-danger">
                      {{ session('delete_fail') }}
                  </div>
                @endif

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <a href="{{url('estaciones/create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Estación</a>
                  </div>
                </div>

                @include('estaciones.filters')

                @if( $estaciones->count() > 0)
                <div class="row">
                  <div class="col-md-4 mb-4">
                    Encontrados: {{$estaciones->count()}} de {{$estaciones->total()}}
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped table-condensed">
                    <thead>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Localidad</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                    </thead>
                    <tbody>
                        @foreach( $estaciones as $estacion)
                          <tr>
                              <td>
                                <p>{{ $estacion->nombre }}</p>
                                <small>Registro: {{ $estacion->created_at }}</small>
                              </td>
                              <td>{{ $estacion->empresa }}
                                <p>
                                  <small>{{ $estacion->telefono }}</small>
                                </p></td>
                              <td>{{ $estacion->localidad }}</td>
                              <td>{{ $estacion->direccion }}</td>
                              <td>
                                  <action-icons url="{{ url('estaciones') }}" :id="{{ $estacion->id }}" token="{{ csrf_token() }}"></action-icons>
                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>

                {{ $estaciones->links() }}
                @else
                <div class="row">
                  <div class="col-md-3 mb-3">
                    No se encontraron resultados
                  </div>
                </div>
                @endif
              </div>
          </div>


        </div>
    </div>
</div>
