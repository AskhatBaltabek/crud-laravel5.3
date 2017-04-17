<?php
  $input_name = isset($input['input_name']) ? $input['input_name'] : $label;
  $multiple = isset($input['multiple']) ? 'multiple' : '';
  $required = isset($input['required']) ? 'required' : '';
?>
<div class="form-group">

  <label class="col-sm-2 control-label">{{ trans('model.' . $label) }}</label>
  <div class="col-sm-10">
    <select class="form-control select2" name="{{ $input_name }}" {{ $multiple }} {{ $required }} data-placeholder="" style="width: 100%;">

      @foreach($input['values'] as $value)
        @if (isset($input['multiple']))
          <?php
          $selected = '';

          if (isset($data)) {
            $res = $data['relations'][$label]->search(function($item) use($value) {
              return $item->id == $value->id;
            });

            $selected = ($res !== false) ? 'selected' : '';
          }
          ?>
          <option value="{{ $value->id }}" {{ $selected }} >{{ $value->getTitle() }}</option>
        @else
          <?php
          $selected = '';

          if (isset($data)) {
            $selected = ($value->id == $data->$input_name) ? 'selected' : '';
          }
          ?>
          <option value="{{ $value->id }}" {{ $selected }} >{{ $value->getTitle() }}</option>
        @endif
      @endforeach
    </select>
  </div>
</div>