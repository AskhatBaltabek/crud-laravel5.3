<?php
  $required = isset($input['required']) ? 'required' : '';
  $value = isset($data) ? $data->$label : old($label);

  $image = $value ? "<img style='max-widht:500px; max-height:200px;' src='" . $value  . "'>" : '';
?>

<div class="form-group">
  <label for="" class="col-sm-2 control-label">{{ trans('model.' . $label) }}</label>

  <div class="col-sm-10">
    {!! $image !!}
    <input type="file" class="form-control" id="" placeholder="" name="{{ $label }}" value="{{ $value }}" {{ $required }}>
  </div>
</div>