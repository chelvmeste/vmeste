@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('user.register.title') }}</h3>
                <hr />

                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                            @endforeach
                        </div>
                    @endif

                    <form role="form" method="POST" action="{{ URL::route('registerPost') }}">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label for="first_name">{{ trans('user.register.first_name') }}:</label>
                            {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control','id'=>'first_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            <label for="last_name">{{ trans('user.register.last_name') }}:</label>
                            {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control','id'=>'last_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                            <label for="username">{{ trans('user.register.username') }}:</label>
                            {{ Form::text('username', Input::old('username'), array('class' => 'form-control','id'=>'username')) }}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ trans('user.register.email') }}:</label>
                            {{ Form::text('email', Input::old('email'), array('class' => 'form-control','id'=>'email')) }}
                        </div>
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label for="password">{{ trans('user.register.password') }}:</label>
                            {{ Form::password('password', array('class' => 'form-control','id'=>'password')) }}
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('user.register.password_confirm') }}:</label>
                            {{ Form::password('password_confirmation', array('class' => 'form-control','id'=>'password_confirmation')) }}
                        </div>
                        <button type="submit" class="btn btn-success">{{ trans('user.register.submit') }}</button>
                    </form>

            </div>
        </div>
    </div>

@stop