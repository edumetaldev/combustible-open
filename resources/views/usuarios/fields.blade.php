<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('DNI') }}</label>

    <div class="col-md-6">
        <input id="dni" type="text" class="form-control{{ $errors->has('dni') ? ' is-invalid' : '' }}" name="dni" value="{{ old('dni',$usuario->dni) }}" required autofocus>

        @if ($errors->has('dni'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('dni') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

    <div class="col-md-6">
        <input id="dni" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre',$usuario->nombre) }}" required autofocus>

        @if ($errors->has('nombre'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nombre') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Oficina') }}</label>

    <div class="col-md-6">
        <input id="oficina" type="text" class="form-control{{ $errors->has('oficina') ? ' is-invalid' : '' }}" name="oficina" value="{{ old('oficina',$usuario->oficina) }}" autofocus>

        @if ($errors->has('oficina'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('oficina') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>

    <div class="col-md-6">
        <select id="rol" name="rol" class="form-control{{ $errors->has('rol') ? ' is-invalid' : '' }}" required>
          <option value="" {{ old('rol',$usuario->rol)  == '' ? ' selected': ''}}> Roles </option>
          <option value="administrador" {{ old('rol',$usuario->rol)  == 'administrador' ? ' selected': ''}}> Administrador </option>
          <option value="visor_cuentas" {{ old('rol',$usuario->rol)  == 'visor_cuentas' ? ' selected': ''}}> Visor Cuentas </option>
          <option value="usuario" {{ old('rol',$usuario->rol)  == 'usuario' ? ' selected': ''}}> Usuario </option>
          <option value="expendedor" {{ old('rol',$usuario->rol)  == 'expendedor' ? ' selected': ''}}> Expendedor </option>
          <option value="cuenta_principal" {{ old('rol',$usuario->rol)  == 'cuenta_principal' ? ' selected': ''}}> Cuenta Principal </option>
        </select>

        @if ($errors->has('rol'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('rol') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$usuario->email) }}" placeholder="nomail@combustible.app">

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="es_cuenta_principal" class="col-md-4 col-form-label text-md-right">{{ __('Es Cuenta /c principal ') }}</label>

    <div class="col-md-1">
        <input id="es_cuenta_principal" type="checkbox" class="form-control" name="es_cuenta_principal" value="1" {{ old('es_cuenta_principal',$usuario->es_cuenta_principal) == 1? 'checked': '' }} >
    </div>
</div>

<div class="form-group row">
    <label for="cuenta_principal_id" class="col-md-4 col-form-label text-md-right">{{ __('Cuenta principal ') }}</label>

    <div class="col-md-6">
          @php
          $cuentas = App\User::where('es_cuenta_principal',true)->get();
        @endphp
        <select id="cuenta_principal_id" name="cuenta_principal_id" class="form-control">
          <option value=""  {{ old('cuenta_principal_id',$usuario->cuenta_principal_id) == '' ? 'selected': '' }} >
            Seleccione una cuenta principal
          </option>
          @foreach($cuentas as $cuenta)
          <option value="{{ $cuenta->id }}" {{ old('cuenta_principal_id',$usuario->cuenta_principal_id) == $cuenta->id ? 'selected': '' }}>
            {{ $cuenta->nombre }}
          </option>
          @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
  <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Comentarios') }}</label>

  <div class="col-md-6">
      <textarea id="comentarios" class="form-control{{ $errors->has('comentarios') ? ' is-invalid' : '' }}" name="comentarios">{{ old('comentarios',$usuario->comentarios) }}</textarea>
  </div>
  @if ($errors->has('comentarios'))
      <span class="invalid-feedback" role="alert">
          <strong>{{ $errors->first('comentarios') }}</strong>
      </span>
  @endif
</div>
<div class="form-group row">
    <label for="cuenta_principal" class="col-md-4 col-form-label text-md-right">{{ __('Estación') }}</label>

    <div class="col-md-6">
        @php
          $estaciones = \DB::Table('estaciones')->get();
        @endphp
        <select id="estacion_id" name="estacion_id" class="form-control{{ $errors->has('estacion_id') ? ' is-invalid' : '' }}">
          <option value=""  {{ old('estacion_id',$usuario->estacion_id) == '' ? 'selected': '' }} >
            Seleccione una Estación
          </option>
          @foreach($estaciones as $estacion)
          <option value="{{ $estacion->id }}" {{ old('estacion_id',$usuario->estacion_id) == $estacion->id ? 'selected': '' }}>
            {{ $estacion->nombre }}
          </option>
          @endforeach
        </select>
        @if ($errors->has('estacion_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('estacion_id') }}</strong>
            </span>
        @endif
    </div>

</div>
