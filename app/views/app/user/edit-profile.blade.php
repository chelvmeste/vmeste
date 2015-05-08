@extends('layouts.app.layout')
@section('content')

    <div class="row edit-profile">
        <div class="col-lg-7 col-lg-offset-1">
            <h3>
                {{ trans('user.edit-profile.title') }}
                <a href="{{ URL::route('profileGet', ['id' => Sentry::getUser()->getId()]) }}">Мой профиль</a>
            </h3>
        </div>
    </div>
    <div class="row edit-profile">
        <div class="col-md-6 col-md-offset-3">

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

            <form role="form" class="form-horizontal" method="POST" action="{{ URL::route('editProfilePost') }}">
                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first_name" class="col-lg-4">{{ trans('user.first_name') }}:</label>
                    <div class="col-lg-8">
                        {{ Form::text('first_name', $user->first_name, array('class' => 'form-control','id'=>'first_name')) }}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <label for="last_name" class="col-lg-4">{{ trans('user.last_name') }}:</label>
                    <div class="col-lg-8">
                        {{ Form::text('last_name', $user->last_name, array('class' => 'form-control','id'=>'last_name')) }}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="col-lg-4">{{ trans('user.email') }}:</label>
                    <div class="col-lg-8">
                        {{ Form::text('email', $user->email, array('class' => 'form-control','id'=>'email')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-lg-4">{{ trans('user.gender') }}:</label>
                    <div class="col-lg-8">
                        {{ Form::select('gender',trans('global.genders'),$user->gender,array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
                    <label for="daterimepicker-birthdate" class="col-lg-4">{{ trans('user.birthdate') }}:</label>
                    <div class="col-lg-8">
                        <div class="form-inline">
                            {{ Form::selectDays('birthdate[day]', Input::old('birthdate.day', Date::parse($user->birthdate)->format('j')), ['class' => 'form-control']) }}
                            {{ Form::selectMonths('birthdate[month]', Input::old('birthdate.month', Date::parse($user->birthdate)->format('n')), ['class' => 'form-control']) }}
                            {{ Form::selectYears('birthdate[year]', 1920, Input::old('birthdate.year', Date::parse($user->birthdate)->format('Y')), ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('vk_id') ? 'has-error' : '' }}">
                    <label for="vk_id" class="col-lg-4">{{ trans('user.vk_id') }}:</label>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <div class="input-group-addon">{{ trans('user.vk_id_prepopulate') }}</div>
                            {{ Form::text('vk_id', $user->vk_id, array('class' => 'form-control','id'=>'vk_id','placeholder'=>'id1')) }}
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="vk_id" class="col-lg-4">{{ trans('user.phone') }}:</label>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <div class="input-group-addon">{{ trans('user.phone_prepopulate') }}</div>
                            {{ Form::text('phone', $user->phone, array('class' => 'form-control','id'=>'phone','placeholder'=>'79251112233')) }}
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address" class="col-lg-4">{{ trans('user.address') }}:</label>
                    <div class="col-lg-8">
                        @if(Config::get('geo.prepopulate') !== null || Config::get('geo.prepopulate') !== '')
                            {{ Form::text('address', $user->address, array('class' => 'form-control','id'=>'address')) }}
                        @else
                            {{ Form::text('address', $user->address, array('class' => 'form-control','id'=>'address')) }}
                        @endif
                        {{ Form::hidden('address_latitude',$user->address_latitude, array('id'=>'address_latitude')) }}
                        {{ Form::hidden('address_longitude',$user->address_longitude, array('id'=>'address_longitude')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-warning">{{ trans('user.edit-profile.submit') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop
