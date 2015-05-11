@extends('layouts.app.layout')
@section('content')

    <div class="row offer">
        <div class="{{ Blind::isEnabled() ? 'col-md-6 col-md-offset-3' : 'col-md-12' }}">
            <h3>{{ trans('offer.help-offer-view.title') }}</h3>
            @if($canEdit)
                <a class="edit-link" href="{{ URL::route('helpOfferEditGet', ['id' => $offer->id]) }}">{{ trans('offer.edit') }}</a>
            @endif
        </div>
    </div>
    <div class="row offer">
        <div class="col-lg-6{{ Blind::isEnabled() ? ' col-lg-offset-3' : '' }}">

            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
            @elseif(Session::has('success'))
                <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
            @endif

            @include('app.offer.help-offer-partial')

        </div>
        @if(!Blind::isEnabled())
            <div class="col-lg-6">
                <div id="map" class="profile-map"></div>
            </div>
        @endif
    </div>

@stop
