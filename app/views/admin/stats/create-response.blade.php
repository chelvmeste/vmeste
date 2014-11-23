@extends(Config::get('syntara::views.master'))
@section('content')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/moment.ru.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/admin/statistics.js') }}"></script>

<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('admin.navigation.statistics.create-response') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('admin.stats.stats-partial')
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
                            <label for="dateStart">{{ trans('admin.date-start') }}</label>
                            <div class="input-group date" id="dateStart-datepicker">
                                <input type='text' class="form-control" data-date-format="YYYY-MM-DD" value="{{ $datas['dateStart'] }}" name="dateStart"/>
                            	<span class="input-group-addon">
                            	    <span class="glyphicon glyphicon-calendar"></span>
                            	</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dateEnd">{{ trans('admin.date-end') }}</label>
                            <div class="input-group date" id="dateEnd-datepicker">
                                <input type='text' class="form-control" data-date-format="YYYY-MM-DD" value="{{ $datas['dateEnd'] }}" name="dateEnd"/>
                            	<span class="input-group-addon">
                            	    <span class="glyphicon glyphicon-calendar"></span>
                            	</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="responseInitiator">{{ trans('admin.response-initiator') }}</label>
                            <select class="form-control" name="responseInitiator" id="responseInitiator">
                                <option value="">---</option>
                                <option value="offer">{{ trans('admin.offerer') }}</option>
                                <option value="request">{{ trans('admin.requester') }}</option>
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