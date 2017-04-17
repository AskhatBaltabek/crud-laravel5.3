<tr>
    @foreach($row as $col)
        <td>{!! str_limit($col, 120) !!}</td>
    @endforeach

    @if (isset($row_actions))
        <td>
        @foreach($row_actions as $action)
            <a href="{{ route('admin:getModelAction', [$model_name ,$action, $row['id']]) }}">{{ trans('model.'.$action) }}</a>
        @endforeach
        </td>
    @endif
</tr>
