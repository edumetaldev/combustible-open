<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

    <div class="col-md-6">
        <input id="dni" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('dni',$estacion->nombre) }}" required autofocus>

        @if ($errors->has('nombre'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nombre') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Empresa') }}</label>

    <div class="col-md-6">
        <input id="empresa" type="text" class="form-control{{ $errors->has('empresa') ? ' is-invalid' : '' }}" name="empresa" value="{{ old('empresa',$estacion->empresa) }}" autofocus>

        @if ($errors->has('empresa'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('empresa') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Localidad') }}</label>

    <div class="col-md-6">
        <input id="localidad" type="text" class="form-control{{ $errors->has('localidad') ? ' is-invalid' : '' }}" name="localidad" value="{{ old('localidad',$estacion->localidad) }}" autofocus>

        @if ($errors->has('localidad'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('localidad') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

    <div class="col-md-6">
        <input id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{ old('direccion',$estacion->direccion) }}" autofocus>

        @if ($errors->has('direccion'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('direccion') }}</strong>
            </span>
        @endif
    </div>
</div>
