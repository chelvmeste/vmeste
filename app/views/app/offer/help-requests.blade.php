@extends('layouts.app.layout')
@section('content')

    <div class="row list">
        <div class="col-lg-10 col-lg-offset-1">
            <h3>{{ trans('offer.help-requests.title') }}</h3>
            @if (count($offers) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('global.user') }}</th>
                            <th>{{ trans('global.date') }}</th>
                            <th>{{ trans('global.description') }}</th>
                            <th width="100"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $offer)
                            <tr>
                                <td><a href="{{ URL::route('profileGet', ['id' => $offer->user->id]) }}">{{ $offer->user->first_name }} {{ $offer->user->last_name }}</a></td>
                                <td>{{ Date::parse($offer->time)->format('H:i') }} {{ Date::parse($offer->date)->format('j-m-Y') }}</td>
                                <td>{{ $offer->description }}</td>
                                <td><a href="{{ URL::route('helpRequestViewGet', ['id' => $offer->id]) }}">{{ trans('global.more') }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>{{ trans('offer.help-requests.empty', ['link' => URL::route('helpRequestNewGet')]) }}</p>
            @endif
        </div>
    </div>

@stop
