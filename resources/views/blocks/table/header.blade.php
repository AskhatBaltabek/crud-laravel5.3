<thead>
<tr>

    @if (isset($data[0]))
        @foreach(array_keys($data[0]) as $col_name)
            <th>{{ trans('model.'.$col_name) }}</th>
        @endforeach
        @if (isset($row_actions) && !empty($row_actions))
            <th>Действия</th>
        @endif
    @endif
</tr>
</thead>