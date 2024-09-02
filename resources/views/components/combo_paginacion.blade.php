<div class="input-group-prepend">
  <div class="input-group-text">
    P
  </div>
</div>
<select id="paginacion" name="paginacion" class="custom-select">
  <option value=""> Resultados </option>
  @for ($i = 1; $i < 6; $i++)
      <option value="{{ ($i * 10) }}" {{ request('paginacion') == ($i * 10) ? ' selected': '' }}> {{ $i * 10 }} </option>
  @endfor
  <option value="100" {{ request('paginacion') == '100' ? ' selected': '' }}> 100 </option>
</select>
