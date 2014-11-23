@extends('layouts.app.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>{{ trans('offer.help-request-view.title') }}</h3>
                @if($canEdit)
                    <a href="{{ URL::route('helpRequestEditGet', ['id' => $offer->id]) }}"><i class="glyphicon glyphicon-pencil"></i> {{ trans('offer.edit') }}</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">

                @if(Session::has('error'))
                    <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
                @elseif(Session::has('success'))
                    <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
                @endif

                @include('app.offer.help-request-partial')

            </div>
            <div class="col-lg-6">
                <div id="map"></div>
            </div>
        </div>
    </div>

@stop