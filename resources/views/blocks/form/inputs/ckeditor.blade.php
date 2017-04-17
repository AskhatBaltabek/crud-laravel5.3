<?php
  $required = isset($input['required']) ? 'required' : '';
  $value = isset($data) ? $data->$label : old($label);
?>

<div class="form-group">
  <label for="" class="col-sm-2 control-label">{{ trans('model.' . $label) }}</label>

  <div class="col-sm-10">
    <textarea name="{{ $label }}" id="{{ $label }}" rows="10" cols="80"{{ $required }}>
        {{ $value }}
    </textarea>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( '{{ $label }}' );
    </script>
  </div>
</div>
