@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h3>{{ trans('offer.help-offers.title') }}</h3>
                <hr>
                @if (count($offers) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('global.user') }}</th>
                                <th>{{ trans('global.time') }}</th>
                                <th>{{ trans('global.interests') }}</th>
                                <th width="100"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offers as $offer)
                                <tr>
                                    <td><a href="{{ URL::route('profileGet', ['id' => $offer->user->id]) }}">{{ $offer->user->first_name }} {{ $offer->user->last_name }}</a></td>
                                    <td>{{ Date::parse($offer->time)->format('H:i') }}</td>
                                    <td>{{ $offer->description }}</td>
                                    <td><a href="{{ URL::route('helpOfferViewGet', ['id' => $offer->id]) }}">{{ trans('global.more') }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>{{ trans('offer.help-offers.empty', ['link' => URL::route('helpOfferGet')]) }}</p>
                @endif
            </div>
        </div>
    </div>

@stop