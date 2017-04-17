

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Data Table With Full Features</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      @if (! empty($data))
        <table class="table table-bordered table-striped model-list-table">
          @include('blocks.table.header')
          <tbody>
            @foreach($data as $row)
              @include('blocks.table.row')
            @endforeach
          </tbody>
          @include('blocks.table.footer')
        </table>
      @endif
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
