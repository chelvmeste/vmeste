@extends('layouts.app.layout')
@section('content')

    <div class="enter-block-outer">
        <div class="enter-block">
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

            <form role="form" method="POST" action="{{ URL::route('loginPost') }}">
                <div class="enter-form-row">
                    <label for="email">
                        {{ trans('user.email') }}:
                    </label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="enter-form-row">
                    <label for="password">
                        {{ trans('user.password') }}:
                    </label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="enter-form-row submit-outer">
                    <button type="submit">{{ trans('user.login.enter') }}</button>
                </div>
            </form>
        </div>
    </div>

@stop
