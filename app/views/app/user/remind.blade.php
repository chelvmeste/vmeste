@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('user.remind.title') }}</h3>
                <hr />

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
                    <button type="submit" class="btn btn-success">{{ trans('user.remind.submit') }}</button>
                </form>

            </div>
        </div>
    </div>

@stop