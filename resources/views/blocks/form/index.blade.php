<?php

$form_route_options = [
  $model_name,
  $page_action
];

if (isset($data)) {
  $form_route_options[] = $data['id'];
}

?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Horizontal Form</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form class="form-horizontal" method="POST" action="{{ route('admin:postModelAction', $form_route_options) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="box-body">
      @foreach($inputs as $label => $input)
        @if (View::exists('blocks.form.inputs.' . $input['type']))
          @include('blocks.form.inputs.' . $input['type'])
        @else
          @include('blocks.form.inputs.text')
        @endif
      @endforeach
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="reset" class="btn btn-default">Отменить</button>
      <button type="submit" class="btn btn-info pull-right">Отправить</button>
    </div>
    <!-- /.box-footer -->
  </form>
</div>