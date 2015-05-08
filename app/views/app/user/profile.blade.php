@extends('layouts.app.layout')
@section('content')

    <div class="row profile">
        <div class="col-lg-7">
            <h3>{{ trans('user.profile.title') }}
                @if(Sentry::check() && Sentry::getUser()->getId() === $user->id)
                    <a href="{{ URL::route('editProfileGet') }}">{{ trans('user.edit-profile.title') }}</a><br /><br />
                @endif
            </h3>

            <table class="table">
                <tr>
                    <td width="200">{{ trans('user.first_name') }}:</td>
                    <td class="name">
                        @if(!empty($user->first_name))
                            {{ $user->first_name }} {{ $user->last_name }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ trans('user.email') }}:</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @if(Sentry::check() && (Sentry::getUser()->hasAccess(Config::get('syntara::permissions.showUser')) || Sentry::getUser()->getId() === $user->id))
                    @if(!empty($user->vk_id))
                        <tr>
                            <td>{{ trans('user.vk_id') }}:</td>
                            <td><a href="http://vk.com/{{ $user->vk_id }}">{{ $user->vk_id }}</a></td>
                        </tr>
                    @endif
                    @if(!empty($user->phone))
                        <tr>
                            <td>{{ trans('user.phone') }}:</td>
                            <td>+{{ $user->phone }}</td>
                        </tr>
                    @endif
                @endif
                @if(in_array($user->gender,array('male','female')))
                    <tr>
                        <td>{{ trans('user.gender') }}:</td>
                        <td>{{ trans('global.genders.'.$user->gender) }}</td>
                    </tr>
                @endif
                @if($user->birthdate !== '0000-00-00')
                    <tr>
                        <td>{{ trans('user.birthdate') }}:</td>
                        <td>{{ $user->birthdate }}</td>
                    </tr>
                @endif
                <tr>
                    <td>{{ trans('user.address') }}:</td>
                    <td>
                        @if(!empty($user->address))
                            {{ $user->address }}
                        @else
                            {{trans('offer.no-address')}}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

@stop
