<?php
  $input_name = isset($input['input_name']) ? $input['input_name'] : $label;
?>

<div class="form-group">
  <label class="col-sm-2 control-label">{{ trans('model.' . $label) }}</label>
  <div class="col-sm-10">
    <div class="row">
        @foreach($input['values'] as $value)
            <?php

            $checked = '';
            $pivot_required = '';
            $pivot_value = null;
            $pivot_name = '[' . $value->id . '][' . $input['pivot'][0] . ']';
            $pivot_name = str_replace('[]', $pivot_name, $input_name);

            if (isset($data)) {
              $res = $data->$label->search(function($item) use($value) {
                return $item->id == $value->id;
              });


              if ($res !== false) {
                $checked = 'checked';
                $pivot_required = 'required';

                $pivot_value = $data->$label;
                $pivot_value = $pivot_value[$res]->pivot->$input['pivot'][0];
              } else {
                $res = $data->company->$label->search(function($item) use($value) {
                  return $item->id == $value->id;
                });

                if ($res !== false) {
                    
                  $pivot_value = $data->company->$label;
                  $pivot_value = $pivot_value[$res]->pivot->$input['pivot'][0];
                }
              }
            }
            ?>
            <div class="col-xs-2">
                <div class="input-group">
                    <span class="input-group-addon">
                        <label><input class="with_pivot_checkbox" type="checkbox" name="{{ $input_name }}" {{ $checked }} value="{{ $value->id }}">{{ $value->title }}</label>
                    </span>
                    <input type="number" data-name="{{ $pivot_name }}" value="{{ $pivot_value }}" class="form-control with_pivot_input" {{ $pivot_required }}>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</div>

<script>
    $('.with_pivot_checkbox').change(function () {
        var pivot_input = $(this).closest('.input-group').find('.with_pivot_input');
        if ($(this).prop('checked')) {
            var pivot_input_name = pivot_input.data('name');
            pivot_input.attr('name', pivot_input_name);
            pivot_input.attr('required', 'required');
        } else {
            pivot_input.removeAttr('name');
            pivot_input.removeAttr('required');
        }
    });
</script>