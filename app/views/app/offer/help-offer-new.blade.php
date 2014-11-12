@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('offer.help-offer.title') }}</h3>
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

                    <form role="form" method="POST" action="{{ URL::route('requestPost') }}">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label for="first_name">{{ trans('user.first_name') }}:</label>
                            {{ Form::text('first_name', $errors->has('first_name') ? Input::old('first_name') : $user->first_name, array('class' => 'form-control','id'=>'first_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            <label for="last_name">{{ trans('user.last_name') }}:</label>
                            {{ Form::text('last_name', $errors->has('last_name') ? Input::old('last_name') : $user->last_name, array('class' => 'form-control','id'=>'last_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ trans('user.email') }}:</label>
                            {{ Form::text('email', $errors->has('email') ? Input::old('email') : $user->email, array('class' => 'form-control','id'=>'email')) }}
                        </div>
                        <div class="form-group">
                            <label for="gender">{{ trans('user.gender') }}:</label>
                            {{ Form::select('gender',trans('global.genders'),$user->gender,array('class'=>'form-control')) }}
                        </div>
                        <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
                            <label for="daterimepicker-birthdate">{{ trans('user.birthdate') }}:</label>
                            <div class="input-group date" id="daterimepicker-birthdate">
                                <input type='text' class="form-control" data-date-format="YYYY-MM-DD" value="{{ $user->birthdate !== '0000-00-00' ? $user->birthdate : null }}" name="birthdate"/>
                            	<span class="input-group-addon">
                            	    <span class="glyphicon glyphicon-calendar"></span>
                            	</span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('vk_id') ? 'has-error' : '' }}">
                            <label for="vk_id">{{ trans('user.vk_id') }}:</label>
                            <div class="input-group">
                                <div class="input-group-addon">{{ trans('user.vk_id_prepopulate') }}</div>
                                {{ Form::text('vk_id', $errors->has('vk_id') ? Input::old('vk_id') : $user->vk_id, array('class' => 'form-control','id'=>'vk_id','placeholder'=>'id1')) }}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="vk_id">{{ trans('user.phone') }}:</label>
                            <div class="input-group">
                                <div class="input-group-addon">{{ trans('user.phone_prepopulate') }}</div>
                                {{ Form::text('phone', $errors->has('phone') ? Input::old('phone') : $user->phone, array('class' => 'form-control','id'=>'phone','placeholder'=>'79251112233')) }}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address">{{ trans('user.address') }}:</label>
                            {{ Form::text('address', $errors->has('address') ? Input::old('address') : $user->address, array('class' => 'form-control','id'=>'address')) }}
                            {{ Form::hidden('address_latitude',$errors->has('address') ? Input::old('address_latitude') : $user->address_latitude, array('id'=>'address_latitude')) }}
                            {{ Form::hidden('address_longitude',$errors->has('address') ? Input::old('address_longitude') : $user->address_longitude, array('id'=>'address_longitude')) }}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('offer.help-offer.days') }}:</label>
                            @for($i = 1; $i <= 7; $i++)
                                <div class="day-container">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="offer-day-switcher" name="days[{{ $i }}][enabled]" data-day="{{ $i }}" id="day_{{ $i }}" value="1" {{ Input::old('days.'.$i.'.enabled') == 1 ? 'checked' : '' }}>
                                            {{ trans('global.days.'.$i) }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group {{ $errors->has('days.'.$i.'.time_start') ? 'has-error' : '' }}">
                                            <div class="input-group offer-time offer-time-start" id="time_start_{{ $i }}">
                                                <input type="text" class="form-control" name="days[{{ $i }}][time_start]" value="{{ Input::old('days.'.$i.'.time_start') }}" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </div>
                                        -
                                        <div class="form-group {{ $errors->has('days.'.$i.'.time_end') ? 'has-error' : '' }}">
                                            <div class="input-group offer-time offer-time-end" id="time_end_{{ $i }}">
                                                <input type="text" class="form-control" name="days[{{ $i }}][time_end]" value="{{ Input::old('days.'.$i.'.time_end') }}" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">{{ trans('offer.help-request.description') }}:</label>
                            {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control','id'=>'description')) }}
                        </div>
                        {{ Form::hidden('type',2) }}
                        <button type="submit" class="btn btn-success">{{ trans('user.edit-profile.submit') }}</button>
                    </form>

            </div>
        </div>
    </div>

@stop