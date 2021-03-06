@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <h3>{{ trans('offer.help-request.title') }}</h3>
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
                            <div class="form-inline">
                                {{ Form::selectDays('birthdate[day]', Input::old('birthdate.day', Date::parse($user->birthdate)->format('j')), ['class' => 'form-control']) }}
                                {{ Form::selectMonths('birthdate[month]', Input::old('birthdate.month', Date::parse($user->birthdate)->format('n')), ['class' => 'form-control']) }}
                                {{ Form::selectYears('birthdate[year]', 1920, Input::old('birthdate.year', Date::parse($user->birthdate)->format('Y')), ['class' => 'form-control']) }}
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
                        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                            <label for="datepicker-offer">{{ trans('offer.help-request.date') }}:</label>
                            <div class="form-inline">
                                {{ Form::selectDays('date[day]', Input::old('date.day'), ['class' => 'form-control']) }}
                                {{ Form::selectMonths('date[month]', Input::old('date.month'), ['class' => 'form-control']) }}
                                {{ Form::selectYears('date[year]', null, Input::old('date.year'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('time') ? 'has-error' : '' }}">
                            <label for="timepicker-offer">{{ trans('offer.help-request.time') }}:</label>
                            <div class="form-inline">
                                <select class="form-control" name="time[hours]" id="time_hours">
                                    @for($j=0;$j<=23;$j++)
                                        <option value="{{ $j }}"{{ Input::old('time.hours') == $j ? ' selected' : '' }}>{{ strlen($j) == 1 ? '0'.$j : $j }}</option>
                                    @endfor
                                </select>
                                <select class="form-control" name="time[minutes]" id="time_minutes">
                                    @for($j=0;$j<=3;$j++)
                                        <option value="{{ strlen($j*15) == 1 ? '00' : $j*15 }}"{{ Input::old('time.minutes') == $j ? ' selected' : '' }}>{{ strlen($j*15) == 1 ? '00' : $j*15 }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">{{ trans('offer.help-request.description') }}:</label>
                            {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control','id'=>'description')) }}
                        </div>
                        {{ Form::hidden('type',1) }}
                        <button type="submit" class="btn btn-success">{{ trans('user.edit-profile.submit') }}</button>
                    </form>

            </div>
        </div>
    </div>

@stop
