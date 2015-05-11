@extends('layouts.app.layout')
@section('content')

    <div class="row list">
        <div class="col-lg-10 col-lg-offset-1">
            <h3>{{ trans('offer.help-offers.title') }}</h3>
            @if (count($offers) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('global.user') }}</th>
                            <th>{{ trans('offer.help-offer-view.days') }}</th>
                            <th>{{ trans('global.description') }}</th>
                            <th width="100"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $offer)
                            <tr>
                                <td><a href="{{ URL::route('profileGet', ['id' => $offer->user->id]) }}">{{ $offer->user->first_name }} {{ $offer->user->last_name }}</a></td>
                                <td>
                                    @foreach($offer->days as $day)
                                        {{ trans('global.days.'.$day['day']) }}: {{ Date::parse($day['time_start'])->format('H:i') }} - {{ Date::parse($day['time_end'])->format('H:i') }} <br />
                                    @endforeach
                                </td>
                                <td>{{ $offer->description }}</td>
                                <td><a href="{{ URL::route('helpOfferViewGet', ['id' => $offer->id]) }}">{{ trans('global.more') }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    {{ $links }}
                </div>
            @else
                <p>{{ trans('offer.help-offers.empty', ['link' => URL::route('helpOfferNewGet')]) }}</p>
            @endif
        </div>
    </div>

@stop
