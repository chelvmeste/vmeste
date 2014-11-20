<div class="row upper-menu">
    {{ $links; }}
    <div style="float:right;">
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
        <th class="col-lg-1" style="text-align: center;">Id</th>
        <th class="col-lg-1" style="text-align: center;">Status</th>
        <th class="col-lg-1">{{ trans('admin.date') }}</th>
        <th class="col-lg-2">{{ trans('admin.user') }}</th>
        <th class="col-lg-2">{{ trans('admin.description') }}</th>
        <th class="col-lg-2" style="text-align: center;"></th>
    </tr>
</thead>
<tbody>
    @foreach($offers as $offer)
        <tr>
            <td class="col-lg-1" style="text-align: center;"><input type="checkbox" data-request-id="{{ $offer->id; }}"></td>
            <td class="col-lg-1" style="text-align: center;">{{ $offer->id }}</td>
            <td class="col-lg-1" style="text-align: center;">{{ Date::parse($offer->date . ' ' . $offer->time)->timestamp < time() ? '<span class="label label-warning">'.trans('admin.expired').'</span>' : '<span class="label label-success">'.trans('admin.active').'</span>' }}</td>
            <td class="col-lg-1">{{ Date::parse($offer->date .' '. $offer->time)->format('Y-m-d H:i') }}</td>
            <td class="col-lg-2">{{ $offer->user->first_name }} {{ $offer->user->last_name }}</td>
            <td class="col-lg-2">{{ $offer->description }}</td>
            <td class="col-lg-2" style="text-align: center;">
                <a href="{{ URL::route('showAdminRequest',['id'=>$offer->id]) }}">{{ trans('admin.edit') }}</a>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
