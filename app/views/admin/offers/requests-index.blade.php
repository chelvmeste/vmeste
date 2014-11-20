@extends(Config::get('syntara::views.master'))
@section('content')
<script src="{{ asset('js/admin/requests.js') }}"></script>

    <div class="container" id="main-container">
        @include('syntara::layouts.dashboard.confirmation-modal', array('title' => trans('syntara::all.confirm-delete-title'), 'content' => trans('syntara::all.confirm-delete-message'), 'type' => 'delete-request'))
        <div class="row">
            <div class="col-lg-10">
                <section class="module">
                    <div class="module-head">
                        <b>{{ trans('admin.navigation.offers.requests') }}</b>
                    </div>
                    <div class="module-body ajax-content">
                        @include('admin.offers.requests-list')
                    </div>
                </section>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
    </div>



@stop