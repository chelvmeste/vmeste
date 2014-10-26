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
                            <label for="first_name">{{ trans('user.edit-profile.first_name') }}:</label>
                            {{ Form::text('first_name', $user->first_name, array('class' => 'form-control','id'=>'first_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            <label for="last_name">{{ trans('user.edit-profile.last_name') }}:</label>
                            {{ Form::text('last_name', $user->last_name, array('class' => 'form-control','id'=>'last_name')) }}
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ trans('user.edit-profile.email') }}:</label>
                            {{ Form::text('email', $user->email, array('class' => 'form-control','id'=>'email')) }}
                        </div>
                        <div class="form-group">
                            <label for="gender">{{ trans('user.edit-profile.gender') }}:</label>
                            {{ Form::select('gender',trans('global.genders'),$user->gender,array('class'=>'form-control')) }}
                        </div>
                        <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
                            <label for="daterimepicker-birthdate">{{ trans('user.edit-profile.birthdate') }}:</label>
                            <div class="input-group date" id="daterimepicker-birthdate">
                                <input type='text' class="form-control" data-date-format="YYYY-MM-DD" value="{{ $user->birthdate !== '0000-00-00' ? $user->birthdate : null }}"/>
                            	<span class="input-group-addon">
                            	    <span class="glyphicon glyphicon-calendar"></span>
                            	</span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('vk_id') ? 'has-error' : '' }}">
                            <label for="vk_id">{{ trans('user.edit-profile.vk_id') }}:</label>
                            <div class="input-group">
                                <div class="input-group-addon">{{ trans('user.edit-profile.vk_id_prepopulate') }}</div>
                                {{ Form::text('vk_id', $user->vk_id, array('class' => 'form-control','id'=>'vk_id','placeholder'=>'id1')) }}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="vk_id">{{ trans('user.edit-profile.phone') }}:</label>
                            <div class="input-group">
                                <div class="input-group-addon">{{ trans('user.edit-profile.phone_prepopulate') }}</div>
                                {{ Form::text('phone', $user->phone, array('class' => 'form-control','id'=>'phone','placeholder'=>'79251112233')) }}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address">{{ trans('user.edit-profile.address') }}:</label>
                            {{ Form::text('address', $user->address, array('class' => 'form-control','id'=>'address')) }}
                            {{ Form::hidden('address_latitude',$user->address_latitude, array('id'=>'address_latitude')) }}
                            {{ Form::hidden('address_longitude',$user->address_longitude, array('id'=>'address_longitude')) }}
                        </div>
                        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                            <label for="datepicker-offer">{{ trans('offer.help-request.date') }}:</label>
                            <div class="input-group date" id="datepicker-offer">
                                <input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="date" value="{{ $offer->date !== '0000-00-00' && $offer->date !== NULL ? $offer->date : null }}"/>
                            	<span class="input-group-addon">
                            	    <span class="glyphicon glyphicon-calendar"></span>
                            	</span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('time') ? 'has-error' : '' }}">
                            <label for="timepicker-offer">{{ trans('offer.help-request.time') }}:</label>
                            <div class="input-group date" id="timepicker-offer">
                                <input type='text' class="form-control" name="time" value="{{ $offer->time !== '00:00:00' && $offer->time !== NULL ? Date::parse($offer->time)->format('H:i') : null }}"/>
                            	<span class="input-group-addon">
                            	    <span class="glyphicon glyphicon-time"></span>
                            	</span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">{{ trans('offer.help-request.description') }}:</label>
                            {{ Form::textarea('description', $offer->description, array('class' => 'form-control','id'=>'description')) }}
                        </div>
                        {{ Form::hidden('type',1) }}
                        <button type="submit" class="btn btn-success">{{ trans('user.edit-profile.submit') }}</button>
                    </form>

            </div>
        </div>
    </div>

@stop