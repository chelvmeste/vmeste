@extends('layouts.app.layout')
@section('content')

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 login-form">
            <div class="title">
                {{ trans('user.login.title') }}
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br />
                    @endforeach
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ URL::route('loginPost') }}">
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">
                        {{ trans('user.username') }}:
                    </label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">
                        {{ trans('user.password') }}:
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-4 col-lg-offset-4 text-center">
                        <button type="submit">{{ trans('user.login.enter') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
