@extends('layouts.app.layout')
@section('content')

    <div class="container">

        @if(count($offerResponses) > 0)

            <div class="row">
                <div class="col-lg-12">
                    @foreach($offerResponses as $response)
                        <div class="alert alert-success">
                            @if ($response->offer_user_id === $currentUser->getId())
                                @if($response->offer_user_id === $response->initiator_user_id)
                                {{-- 1 - я хочу помочь кому-то --}}
                                {{ trans('offer.response.1-want-help', ['username' => $response->requestUser->first_name.' '.$response->requestUser->last_name, 'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id])]) }}
                                @else
                                {{-- 2 - ко мне обратились за помощью --}}
                                {{ trans('offer.response.2-somebody-request-help', ['username' => $response->requestUser->first_name.' '.$response->requestUser->last_name, 'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id])]) }}
                                @endif
                            @elseif($response->request_user_id === $currentUser->getId())
                                @if($response->request_user_id === $response->initiator_user_id)
                                {{-- 3 - вы попросили о помощи --}}
                                {{ trans('offer.response.3-you-request-help', ['username' => $response->offerUser->first_name.' '.$response->offerUser->last_name, 'offerLink' => URL::route('helpOfferViewGet', ['id' => $response->offer_id]), 'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id])]) }}
                                @else
                                {{-- 4 - вам хотят помочь --}}
                                {{ trans('offer.response.3-somebody-want-help', ['username' => $response->offerUser->first_name.' '.$response->offerUser->last_name, 'offerLink' => URL::route('helpOfferViewGet', ['id' => $response->offer_id]), 'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id])]) }}
                                @endif
                            @endif
                            <div class="pull-right">
                                <a href="#" class="btn btn-xs btn-success">{{ trans('offer.response.helped') }}</a>
                                <a href="#" class="btn btn-xs btn-danger">{{ trans('offer.response.cancel') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @endif

        <div class="row">
            <div class="col-lg-12">
                <div id="map"></div>
            </div>
        </div>
    </div>

@stop