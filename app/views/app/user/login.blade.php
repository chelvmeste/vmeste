@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('user.login.title') }}</h3>
                <hr />

                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                            @endforeach
                        </div>
                    @endif

                <form role="form" method="POST" action="{{ URL::route('loginPost') }}">
                    <div class="form-group">
                        <label for="email">{{ trans('user.email') }}:</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">{{ trans('user.password') }}:</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" value="1"> {{ trans('user.login.remember') }}
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success">{{ trans('user.login.enter') }}</button>
                </form>

                <p class="text-center" style="margin-top: 30px;">
                    {{--<a href="{{ URL::route('registerGet') }}">{{ trans('user.login.register') }}</a>
                    |--}}
                    <a href="{{ URL::route('remindGet') }}">{{ trans('user.login.remind_password') }}</a>
                </p>

            </div>
        </div>
    </div>

@stop