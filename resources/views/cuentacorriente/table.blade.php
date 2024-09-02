<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
              <div class="card-header">Cuenta Corriente</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <a href="{{url('cuentacorriente/iniciar/0')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Iniciar Cuenta Corriente</a>
                  </div>
                </div>

                @include('cuentacorriente.filters')

                @if( $cc->count() > 0)
                <div class="row">
                  <div class="col-md-4 mb-4">
                    Encontrados: {{ $cc->count() }} de {{$cc->total()}}
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped table-condensed">
                    <thead>
                        <th>Id</th>
                        <th>Cuenta</th>
                        <th>Líneas</th>
                        <th>Saldo</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach( $cc as $cuenta)
                          <tr>
                              <td>
                                <p class="h4">{{ $cuenta->id }}</p>
                              </td>
                              <td>{{ $cuenta->nombre }}</td>
                              <td>{{ $cuenta->linea }}</td>
                              <td>${{ $cuenta->saldo }}</td>
                              <td>
                                <a href="{{ url('cuentacorriente/transferir',$cuenta->usuario_id)}}" class="btn btn-info"> Transferir</a>
                                <a href="{{ url('cuentacorriente/depositar',$cuenta->usuario_id)}}" class="btn btn-info"> Depositar</a>
                                <a href="{{ url('cuentacorriente/extraer',$cuenta->usuario_id)}}" class="btn btn-info"> Extraer</a>
                                <a href="{{ url('cuentacorriente',$cuenta->usuario_id)}}" class="btn btn-info"> Detalle</a>
                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>

                {{ $cc->links() }}
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
