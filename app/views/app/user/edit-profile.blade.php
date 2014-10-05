@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('user.edit-profile.title') }}</h3>
                <hr />

                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                            @endforeach
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    <form role="form" method="POST" action="{{ URL::route('editProfilePost') }}">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label for="first_name">{{ trans('user.edit-profile.first_name') }}:</label>
                            {{ Form::text('first_name', $user->first_name, array('class' => 'form-control','id'=>'first_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            <label for="last_name">{{ trans('user.edit-profile.last_name') }}:</label>
                            {{ Form::text('last_name', $user->last_name, array('class' => 'form-control','id'=>'last_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                            <label for="username">{{ trans('user.edit-profile.username') }}:</label>
                            {{ Form::text('username', $user->username, array('class' => 'form-control','id'=>'username')) }}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ trans('user.edit-profile.email') }}:</label>
                            {{ Form::text('email', $user->email, array('class' => 'form-control','id'=>'email')) }}
                        </div>
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label for="password">{{ trans('user.edit-profile.password') }}:</label>
                            {{ Form::password('password', array('class' => 'form-control','id'=>'password')) }}
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('user.edit-profile.password_confirm') }}:</label>
                            {{ Form::password('password_confirmation', array('class' => 'form-control','id'=>'password_confirmation')) }}
                        </div>
                        <button type="submit" class="btn btn-success">{{ trans('user.edit-profile.submit') }}</button>
                    </form>

            </div>
        </div>
    </div>

@stop