@extends('layouts.app.layout')
@section('content')

    <div class="profile">

        <div class="inf">
            <div class="title-1">
                @if(Sentry::check() && Sentry::getUser()->getId() === $user->id)
                    Мой профиль <span class="redact-profile"><a href="{{ URL::route('editProfileGet') }}">{{ trans('user.edit-profile.title') }}</a></span>
                @else
                    {{ trans('user.profile.title', ['name' => !empty($user->first_name) ? $user->first_name . ' ' . $user->last_name : '']) }}
                @endif
            </div>
            @if(!empty($user->first_name))
                <div class="profile-row">
                    <div class="title">
                        {{ trans('user.first_name') }}:
                    </div>
                    <div class="text">
                        <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                    </div>
                </div>
            @endif
            @if(in_array($user->gender,array('male','female')))
                <div class="profile-row">
                    <div class="title">
                        {{ trans('user.gender') }}:
                    </div>
                    <div class="text">
                        {{ trans('global.genders.'.$user->gender) }}
                    </div>
                </div>
            @endif
            <div class="profile-row">
                <div class="title">
                    {{ trans('user.address') }}:
                </div>
                <div class="text">
                    @if(!empty($user->address))
                        {{ $user->address }}
                    @else
                        {{trans('offer.no-address')}}
                    @endif
                </div>
            </div>
            @if($user->birthdate !== '0000-00-00')
                <div class="profile-row">
                    <div class="title">
                        {{ trans('user.birthdate') }}:
                    </div>
                    <div class="text">
                        {{ $user->birthdate }}
                    </div>
                </div>
            @endif
            @if(Sentry::check() && (Sentry::getUser()->hasAccess(Config::get('syntara::permissions.showUser')) || Sentry::getUser()->getId() === $user->id))
                @if(!empty($user->phone))
                    <div class="profile-row">
                        <div class="title">
                            {{ trans('user.phone') }}:
                        </div>
                        <div class="text">
                            +{{ $user->phone }}
                        </div>
                    </div>
                @endif
            @endif
            <div class="profile-row">
                <div class="title">
                    {{ trans('user.email') }}:
                </div>
                <div class="text">
                    {{ $user->email }}
                </div>
            </div>
            @if(Sentry::check() && (Sentry::getUser()->hasAccess(Config::get('syntara::permissions.showUser')) || Sentry::getUser()->getId() === $user->id))
                @if(!empty($user->vk_id))
                    <div class="profile-row">
                        <div class="title">
                            {{ trans('user.vk_id') }}:
                        </div>
                        <div class="text">
                            <a href="http://vk.com/{{ $user->vk_id }}">{{ $user->vk_id }}</a>
                        </div>
                    </div>
                @endif
            @endif

        </div>

    </div>


@stop
