@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-lg-offset-2">
                <h3>{{ trans('user.profile.title', ['name' => !empty($user->first_name) ? $user->first_name . ' ' . $user->last_name : '']) }}</h3>

                <table class="table">
                    <tr>
                        <td width="200"><strong>{{ trans('user.first_name') }}</strong></td>
                        <td>
                            @if(!empty($user->first_name))
                                {{ $user->first_name }} {{ $user->last_name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>{{ trans('user.email') }}</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @if(Sentry::check() && Sentry::getUser()->hasAccess(Config::get('syntara::permissions.showUser')))
                        @if(!empty($user->vk_id))
                            <tr>
                                <td><strong>{{ trans('user.vk_id') }}</strong></td>
                                <td><a href="http://vk.com/{{ $user->vk_id }}">{{ $user->vk_id }}</a></td>
                            </tr>
                        @endif
                        @if(!empty($user->phone))
                            <tr>
                                <td><strong>{{ trans('user.phone') }}</strong></td>
                                <td>+{{ $user->phone }}</td>
                            </tr>
                        @endif
                    @endif
                    @if(in_array($user->gender,array('male','female')))
                        <tr>
                            <td><strong>{{ trans('user.gender') }}</strong></td>
                            <td>{{ trans('global.genders.'.$user->gender) }}</td>
                        </tr>
                    @endif
                    @if($user->birthdate !== '0000-00-00')
                        <tr>
                            <td><strong>{{ trans('user.birthdate') }}</strong></td>
                            <td>{{ $user->birthdate }}</td>
                        </tr>
                    @endif
                    @if(!empty($user->address))
                        <tr>
                            <td><strong>{{ trans('user.address') }}</strong></td>
                            <td>{{ $user->address }}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="col-lg-3" style="padding-top: 55px;">
                @if(Sentry::check() && Sentry::getUser()->getId() === $user->id)
                    <a href="{{ URL::route('editProfileGet') }}" class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i> {{ trans('user.edit-profile.title') }}</a><br /><br />
                @endif
                {{--@if(!empty($help_request))
                    <a href="{{ URL::route('helpRequestViewGet', ['id' => $help_request->id]) }}" class="btn btn-info">{{ trans('offer.help-request.view') }}</a><br /><br />
                @endif
                @if(!empty($help_offer))
                    <a href="{{ URL::route('helpOfferViewGet', ['id' => $help_offer->id]) }}" class="btn btn-info">{{ trans('offer.help-offer.view') }}</a><br /><br />
                @endif--}}
            </div>
        </div>
    </div>

@stop