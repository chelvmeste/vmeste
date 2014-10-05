@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('user.register.title') }}</h3>
                <hr />

                <p>{{ trans('user.register.success') }}</p>

            </div>
        </div>
    </div>

@stop