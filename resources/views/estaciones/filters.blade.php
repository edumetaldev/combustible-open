<form method="get" action="{{url('estaciones')}}">
  <div class="row">

    <div class="input-group-append col-md-3 mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <span class="fas fa-sort"></span>
          </div>
        </div>

        <select id="ordenarpor" name="ordenarpor" class="form-control">
          <option value=""> Ordenar por </option>
          <option value="nombre" {{ request('ordenarpor') == 'nombre' ? ' selected': ''}}> Nombre </option>
          <option value="empresa" {{ request('ordenarpor') == 'empresa' ? ' selected': ''}}> Empresa </option>
          <option value="localidad" {{ request('ordenarpor') == 'created_at' ? ' selected': ''}}> Localidad </option>
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
        <a href="{{ url('estaciones') }}" class="btn btn-info"> <i class="fas fa-eraser"></i> Limpiar</a>
        @include('components.button_excel')
    </div>
  </div>
</form>
