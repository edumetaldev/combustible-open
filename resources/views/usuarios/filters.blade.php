<form method="get" action="{{url('usuarios')}}">
  <div class="row">

    <div class="input-group-append col-md-3 mb-3">
        <select id="buscarpor" name="buscarpor" class="custom-select" data-style="btn-primary">
          <option value="" {{ request('buscarpor') == '' ? ' selected': ''}}> Buscar por </option>
          <option value="dni" {{ request('buscarpor') == 'dni' ? ' selected': ''}}> DNI </option>
          <option value="email" {{ request('buscarpor') == 'email' ? ' selected': ''}}> Email </option>
          <option value="nombre" {{ request('buscarpor') == 'nombre' ? ' selected': ''}}> Nombre </option>
        </select>
        <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar" value="{{ request('buscar')}}" />
    </div>

    <div class="col-md-2 mb-2">
        <select id="rol" name="rol" class="custom-select d-block w-100" >
          <option value="" {{ request('rol') == '' ? ' selected': ''}}> Roles </option>
          <option value="administrador" {{ request('rol') == 'administrador' ? ' selected': ''}}> Administrador </option>
          <option value="visor_cuentas" {{ request('rol') == 'visor_cuentas' ? ' selected': ''}}> Visor Cuentas </option>
          <option value="usuario" {{ request('rol') == 'usuario' ? ' selected': ''}}> Usuario </option>
          <option value="expendedor" {{ request('rol') == 'expendedor' ? ' selected': ''}}> Expendedor </option>
          <option value="cuenta_principal" {{ request('rol') == 'cuenta_principal' ? ' selected': ''}}> Cuenta Principal </option>
        </select>
    </div>

    <div class="input-group-append col-md-3 mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <span class="fas fa-sort"></span>
          </div>
        </div>

        <select id="ordenarpor" name="ordenarpor" class="form-control">
          <option value=""> Ordenar por </option>
          <option value="dni" {{ request('ordenarpor') == 'dni' ? ' selected': ''}}> DNI </option>
          <option value="email" {{ request('ordenarpor') == 'email' ? ' selected': ''}}> Email </option>
          <option value="created_at" {{ request('ordenarpor') == 'created_at' ? ' selected': ''}}> Registro </option>
        </select>
    </div>

    <div class="input-group-append col-md-3 mb-3">
      @component('components.combo_paginacion')
      @endcomponent
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        <button type="submit" class="btn btn-info"> <i class="fas fa-search"></i> Buscar</button>
        <a href="{{ url('usuarios') }}" class="btn btn-info"> <i class="fas fa-eraser"></i> Limpiar</a>
        @include('components.button_excel')
    </div>
  </div>
</form>
