@extends(Config::get('syntara::views.master'))
@section('content')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" type="text/css">

    <div id="main-container" class="container">
        <div class="row">
            <div class="col-lg-6">
                <section class="module">
                    <div class="module-head">
                        <b>{{ trans('admin.navigation.offers.offer-edit') }}</b>
                    </div>
                    <div class="module-body">
                        @include('app.offer.help-offer-edit-form')
                    </div>
                </section>
            </div>
        </div>
    </div>

<script>var geoConfig = {{ $geoConfig }};</script>
<script src="{{ asset('js/admin/offers.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/moment.ru.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('js/offer.help-offer.js') }}"></script>

@stop