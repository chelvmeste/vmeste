@extends('layouts.app.layout')
@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>{{ trans('user.activate.title') }}</h3>
            <p>{{ $message }}</p>

        </div>
    </div>

@stop
