@if(count($datas['stats']) > 0)
    <table class="table">
        <thead>
            <th>{{ trans('admin.date') }}</th>
            <th>{{ trans('admin.counter') }}</th>
        </thead>
        <tbody>
            @foreach($datas['stats'] as $row)
                <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    {{ trans('admin.no-items') }}
@endif