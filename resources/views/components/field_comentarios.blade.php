<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Comentarios') }}</label>

<div class="col-md-6">
    <textarea id="comentarios" class="form-control{{ $errors->has('comentarios') ? ' is-invalid' : '' }}" name="comentarios">{{old('comentarios')}}</textarea>
</div>
