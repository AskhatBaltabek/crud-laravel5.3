<?php
  $required = isset($input['required']) ? 'required' : '';
  $value = isset($data) ? $data->$label : old($label);
?>

<div class="form-group">
  <label for="" class="col-sm-2 control-label">{{ trans('model.' . $label) }}</label>

  <div class="col-sm-10">
    <input type="text" class="form-control my-colorpicker1" name="{{ $label }}" value="{{ $value }}" {{ $required }}>
  </div>
</div>

