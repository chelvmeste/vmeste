@extends('layouts.app.layout_blind')
@section('content')

    <div class="container">

        @if(count($offerResponses) > 0)

            <div class="row">
                <div class="col-lg-12">
                    @foreach($offerResponses as $response)
                        <div class="alert alert-success response-alert-{{ $response->id }}">
                            @if ($response->offer_user_id === $currentUser->getId())
                                @if($response->offer_user_id === $response->initiator_user_id)
                                {{-- 1 - я хочу помочь кому-то --}}
                                {{ trans('offer.response.1-want-help', [
                                    'username' => $response->requestUser->first_name.' '.$response->requestUser->last_name,
                                    'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id]),
                                    'address' => $response->requestUser->address,
                                    'phone' => $response->requestUser->phone,
                                    'vk_id' => $response->requestUser->vk_id,
                                ]) }}
                                @else
                                {{-- 2 - ко мне обратились за помощью --}}
                                {{ trans('offer.response.2-somebody-request-help', [
                                    'username' => $response->requestUser->first_name.' '.$response->requestUser->last_name,
                                    'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id]),
                                    'address' => $response->requestUser->address,
                                    'phone' => $response->requestUser->phone,
                                    'vk_id' => $response->requestUser->vk_id,
                                ]) }}
                                @endif
                            @elseif($response->request_user_id === $currentUser->getId())
                                @if($response->request_user_id === $response->initiator_user_id)
                                {{-- 3 - вы попросили о помощи --}}
                                {{ trans('offer.response.3-you-request-help', [
                                    'address' => $response->offerUser->address,
                                    'phone' => $response->offerUser->phone,
                                    'vk_id' => $response->offerUser->vk_id,
                                    'username' => $response->offerUser->first_name.' '.$response->offerUser->last_name,
                                    'offerLink' => URL::route('helpOfferViewGet', ['id' => $response->offer_id]),
                                    'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id])
                                ]) }}
                                @else
                                {{-- 4 - вам хотят помочь --}}
                                {{ trans('offer.response.4-somebody-want-help', [
                                    'username' => $response->offerUser->first_name.' '.$response->offerUser->last_name,
                                    'offerLink' => URL::route('helpOfferViewGet', ['id' => $response->offer_id]),
                                    'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id]),
                                    'address' => $response->offerUser->address,
                                    'phone' => $response->offerUser->phone,
                                    'vk_id' => $response->offerUser->vk_id,
                                ]) }}
                                @endif
                            @endif
                            <div class="pull-right">
                                <a href="#" class="btn btn-xs btn-success response-success" data-response-id="{{ $response->id }}">{{ trans('offer.response.helped') }}</a>
                                <a href="#" class="btn btn-xs btn-danger response-cancel" data-response-id="{{ $response->id }}">{{ trans('offer.response.cancel') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal fade" id="response-success-modal" tabindex="-1" role="dialog" aria-labelledby="response-success-modal-label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="response-success-modal-label">{{ trans('offer.response.response_text') }}</h4>
                  </div>
                  <div class="modal-body">
                    <div class="errors"></div>
                    <textarea name="response_text" class="form-control" rows="3"></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.close') }}</button>
                    <button type="button" class="btn btn-success send-response-success">{{ trans('offer.response.helped') }}</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="response-cancel-modal" tabindex="-1" role="dialog" aria-labelledby="response-cancel-modal-label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="response-cancel-modal-label">{{ trans('offer.response.response_text') }}</h4>
                  </div>
                  <div class="modal-body">
                    <textarea name="response_text" class="form-control" rows="3"></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.close') }}</button>
                    <button type="button" class="btn btn-danger send-response-cancel">{{ trans('offer.response.cancel') }}</button>
                  </div>
                </div>
              </div>
            </div>

        @endif

        <div class="row">
            <div class="col-lg-6">
                <h3>{{ trans('global.header.help-offers') }}</h3>
                @if(isset($offers) && count($offers) > 0)
                    <ul class="list-unstyled">
                        @foreach($offers as $offer)
                            <li>
                                <address>
                                    <strong><a href="{{ URL::route('profileGet', ['id' => $offer->user_id]) }}">{{ $offer->user['first_name'] }} {{ $offer->user['last_name'] }}</a></strong><br />
                                    @if($offer->days && count($offer->days) > 0)
                                        <strong>{{ trans('offer.help-offer-view.days') }}:</strong><br />
                                        @foreach($offer->days as $day)
                                            @if($day['active'])
                                                {{ trans('global.days.'.$day['day']) }}: {{ Date::parse($day['time_start'])->format('H:i') }} - {{ Date::parse($day['time_end'])->format('H:i') }} <br />
                                            @endif
                                        @endforeach
                                    @endif
                                    <strong>{{ trans('global.interests') }}:</strong><br />
                                    {{ $offer->description }}<br />
                                    <a href="{{ URL::route('helpOfferViewGet', ['id' => $offer->id]) }}">{{ trans('global.more') }}</a>
                                </address>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{ trans('offer.help-offers.empty', ['link' => URL::route('helpOfferNewGet')]) }}
                @endif
            </div>
            <div class="col-lg-6">
                <h3>{{ trans('global.header.help-requests') }}</h3>
                @if(isset($requests) && count($requests) > 0)
                    <ul class="list-unstyled">
                        @foreach($requests as $request)
                            <li>
                                <address>
                                    <strong><a href="{{ URL::route('profileGet', ['id' => $request->user_id]) }}">{{ $request->user['first_name'] }} {{ $request->user['first_name'] }}</a></strong><br />
                                    {{ Date::parse($request->date)->format('Y-m-d') }} {{ Date::parse($request->time)->format('H:i') }}<br />
                                    <strong>{{ trans('global.interests') }}:</strong><br />
                                    {{ $request->description }}<br />
                                    <a href="{{ URL::route('helpRequestViewGet', ['id' => $request->id]) }}">{{ trans('global.more') }}</a>
                                </address>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{ trans('offer.help-requests.empty', ['link' => URL::route('helpRequestNewGet')]) }}
                @endif
            </div>
        </div>
    </div>

@stop
