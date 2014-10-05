@extends('layouts.app.layout')
@section('content')



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('user.reset.title') }}</h3>
                <hr />

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
                    <input type="hidden" name="token" value="{{ $token }}">
                    <button type="submit" class="btn btn-success">{{ trans('user.reset.submit') }}</button>
                </form>

            </div>
        </div>
    </div>

@stop