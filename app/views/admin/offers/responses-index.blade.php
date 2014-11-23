@extends(Config::get('syntara::views.master'))
@section('content')
<script src="{{ asset('js/admin/responses.js') }}"></script>

    <div class="container" id="main-container">
        @include('syntara::layouts.dashboard.confirmation-modal', array('title' => trans('syntara::all.confirm-delete-title'), 'content' => trans('syntara::all.confirm-delete-message'), 'type' => 'delete-response'))
        <div class="row">
            <div class="col-lg-10">
                <section class="module">
                    <div class="module-head">
                        <b>{{ trans('admin.navigation.offers.responses') }}</b>
                    </div>
                    <div class="module-body ajax-content">
                        @include('admin.offers.responses-list')
                    </div>
                </section>
            </div>
            <div class="col-lg-2">
                <section class="module">
                    <div class="module-head">
                        <b>{{ trans('syntara::all.search') }}</b>
                    </div>
                    <div class="module-body">
                        <form id="search-form" onsubmit="return false;">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">---</option>
                                    <option value="{{ OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE }}">{{ trans('admin.active') }}</option>
                                    <option value="{{ OfferResponse::OFFER_RESPONSE_STATUS_SUCCESS }}">{{ trans('admin.success') }}</option>
                                    <option value="{{ OfferResponse::OFFER_RESPONSE_STATUS_CANCELED }}">{{ trans('admin.canceled') }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ trans('syntara::all.search') }}</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

@stop