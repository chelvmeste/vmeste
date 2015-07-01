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
        <th class="col-lg-1" style="text-align: center;">Status</th>
        <th class="col-lg-1">{{ trans('admin.date') }}</th>
        <th class="col-lg-2">{{ trans('admin.offer-user') }}</th>
        <th class="col-lg-2">{{ trans('admin.request-user') }}</th>
        <th class="col-lg-1">{{ trans('admin.request') }}</th>
        <th class="col-lg-2" style="text-align: center;"></th>
    </tr>
</thead>
<tbody>
    @foreach($offerResponses as $response)
        <tr>
            <td class="col-lg-1" style="text-align: center;"><input type="checkbox" data-response-id="{{ $response->id; }}"></td>
            <td class="col-lg-1" style="text-align: center;">
                @if($response->status == OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE)
                    <span class="label label-default">{{ trans('admin.active') }}</span>
                @elseif($response->status == OfferResponse::OFFER_RESPONSE_STATUS_SUCCESS)
                    <span class="label label-success">{{ trans('admin.success') }}</span>
                @elseif($response->status == OfferResponse::OFFER_RESPONSE_STATUS_CANCELED)
                    <span class="label label-warning">{{ trans('admin.canceled') }}</span>
                @endif
            </td>
            <td class="col-lg-1">{{ Date::parse($response->created_at)->format('Y-m-d H:i') }}</td>
            <td class="col-lg-2"><a href="{{ URL::route('showUser', ['id' => $response->requestUser->id]) }}"{{ $response->requestUser->id == $response->initiator_user_id ? ' style="font-weight: bold;"' : '' }}>{{ $response->requestUser->first_name }} {{ $response->requestUser->last_name }}</a></td>
            <td class="col-lg-2"><a href="{{ URL::route('showUser', ['id' => $response->offerUser->id]) }}"{{ $response->offerUser->id == $response->initiator_user_id ? ' style="font-weight: bold;"' : '' }}>{{ $response->offerUser->first_name }} {{ $response->offerUser->last_name }}</a></td>
            <td class="col-lg-1"><a href="{{ URL::route('showAdminRequest', ['id' => $response->request_id]) }}">{{ trans('admin.view') }}</a></td>
            <td class="col-lg-2" style="text-align: center;">
                <a href="{{ URL::route('showAdminResponse',['id'=>$response->id]) }}">{{ trans('admin.view') }}</a>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
