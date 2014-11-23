@extends(Config::get('syntara::views.master'))
@section('content')
<script src="{{ asset('js/admin/responses.js') }}"></script>

    <div id="main-container" class="container">
        <div class="row">
            <div class="col-lg-6">
                <section class="module">
                    <div class="module-head">
                        <b>{{ trans('admin.navigation.offers.response-view') }}</b>
                    </div>
                    <div class="module-body">
                        <form role="form" id="edit-response-form">
                            <div class="form-group">
                                <label for="request_user">{{ trans('admin.request-user') }}:</label>
                                <span>
                                    <a href="{{ URL::route('showUser', ['id' => $requestUser->id]) }}">{{ $requestUser->first_name . ' ' . $requestUser->last_name }}</a> {{ $response->initiator_user_id == $requestUser->id ? '(' . trans('admin.initiator') . ')' : '' }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="offer_user">{{ trans('admin.offer-user') }}:</label>
                                <span>
                                    <a href="{{ URL::route('showUser', ['id' => $offerUser->id]) }}">{{ $offerUser->first_name . ' ' . $offerUser->last_name }}</a> {{ $response->initiator_user_id == $offerUser->id ? '(' . trans('admin.initiator') . ')' : '' }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="date">{{ trans('admin.date') }}:</label>
                                <span>
                                    {{ Date::parse($response->created_at)->format('d-m-Y H:i') }}
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="status">{{ trans('admin.status') }}:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="{{ OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE }}"{{ $response->status == OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE ? ' selected' : '' }}>{{ trans('admin.active') }}</option>
                                    <option value="{{ OfferResponse::OFFER_RESPONSE_STATUS_SUCCESS }}"{{ $response->status == OfferResponse::OFFER_RESPONSE_STATUS_SUCCESS ? ' selected' : '' }}>{{ trans('admin.success') }}</option>
                                    <option value="{{ OfferResponse::OFFER_RESPONSE_STATUS_CANCELED }}"{{ $response->status == OfferResponse::OFFER_RESPONSE_STATUS_CANCELED ? ' selected' : '' }}>{{ trans('admin.canceled') }}</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="request_response">{{ trans('admin.request-response') }}:</label>
                                {{ Form::textarea('request_response', $response->request_response, array('class' => 'form-control','id'=>'request_response')) }}
                            </div>
                            <div class="form-group">
                                <label for="offer_response">{{ trans('admin.offer-response') }}:</label>
                                {{ Form::textarea('offer_response', $response->offer_response, array('class' => 'form-control','id'=>'offer_response')) }}
                            </div>
                            <button type="submit" class="btn btn-success">{{ trans('user.edit-profile.submit') }}</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

@stop