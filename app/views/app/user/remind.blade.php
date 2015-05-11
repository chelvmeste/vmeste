@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <h3>{{ trans('user.remind.title') }}</h3>

                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                <form role="form" method="POST" action="{{ URL::route('remindPost') }}">
                    <div class="form-group">
                        <label for="email">{{ trans('user.remind.email') }}:</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">{{ trans('user.remind.submit') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop
