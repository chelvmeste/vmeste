@extends('layouts.app.layout')
@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <h3>{{ trans('user.reset.title') }}</h3>

            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <form role="form" method="POST" action="{{ URL::route('resetPost',[$token]) }}">
                <div class="form-group">
                    <label for="email">{{ trans('user.reset.email') }}:</label>
                    <input type="text" class="form-control" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">{{ trans('user.reset.password') }}:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ trans('user.reset.password_confirmation') }}:</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>
                <div class="form-group">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <button type="submit" class="btn btn-warning">{{ trans('user.reset.submit') }}</button>
                </div>
            </form>

        </div>
    </div>

@stop
