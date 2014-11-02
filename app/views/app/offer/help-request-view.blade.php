@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>{{ trans('offer.help-request-view.title') }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">

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
                    @if(!empty($offer->time) && !empty($offer->date))
                        <tr>
                            <td><strong>{{ trans('offer.help-request.date') }}</strong></td>
                            <td>{{ Date::parse($offer->date.' '.$offer->time)->format('H:i d-m-Y') }}</td>
                        </tr>
                    @endif
                    @if(!empty($offer->description))
                        <tr>
                            <td><strong>{{ trans('offer.help-request.description') }}</strong></td>
                            <td>{{ $offer->description }}</td>
                        </tr>
                    @endif
                </table>

            </div>
            <div class="col-lg-6">
                <div id="map"></div>
            </div>
        </div>
    </div>

@stop