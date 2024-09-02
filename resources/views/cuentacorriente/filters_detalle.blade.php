<form method="get" action="{{url('cuentacorriente',$id)}}">
  <div class="row">

    <div class="input-group-append col-md-4">
        <select id="buscarpor" name="buscarpor" class="custom-select" data-style="btn-primary">
          <option value="" {{ request('buscarpor') == '' ? ' selected': ''}}> Filtrar por </option>
          <option value="origen" {{ request('buscarpor') == 'origen' ? ' selected': ''}}> Origen </option>
          <option value="destino" {{ request('buscarpor') == 'destino' ? ' selected': ''}}> Destino </option>
        </select>
        <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar" value="{{ request('buscar')}}" />
    </div>

    <div class="input-group-append col-md-3 mb-3">
      @component('components.combo_paginacion')
      @endcomponent
    </div>
    <div class="input-group-append col-md-3 mb-3">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="fas fa-calendar-alt"></i>
        </div>
      </div>
      <input type="date" name="fecha_desde" class="form-control" placeholder="Fecha Desde" value="{{request('fecha_desde')}}"/>
      <input type="date" name="fecha_hasta" class="form-control" placeholder="Fecha Hasta" value="{{request('fecha_hasta')}}">
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
        <button type="submit" class="btn btn-info"> <i class="fas fa-search"></i> Buscar</button>
        <a href="{{ url('cuentacorriente',$id) }}" class="btn btn-info"> <i class="fas fa-eraser"></i> Limpiar</a>
        @include('components.button_excel')
    </div>
  </div>
</form>
