@if ( isset($data) )
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">
        Data Table With Full Features
      </h3>
      <div class="pull-right">
        @if (isset($row_actions))
            @foreach($row_actions as $action)
                <a href="{{ route('admin:getModelAction', [$model_name ,$action, $data['id']]) }}" class="btn btn-warning">{{ trans('model.'.$action) }}</a>
            @endforeach
            <?unset($row_actions);?>
        @endif
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-striped model-list-table">
        <tbody>
          @foreach($data as $key => $val)
            <?php

            if (isset($inputs[$key]) 
                && $inputs[$key]['type'] == 'image') {
              $val = "<img style='max-widht:500px; max-height:200px;' src='" . $val  . "'>";
            }

            $row = [trans('model.'.$key), $val];

            ?>
            @include('blocks.table.row')
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
@endif
