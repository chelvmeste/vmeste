@extends('layouts.app.layout')
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
            <div class="col-lg-5" id="side-list"></div>
            <div class="col-lg-7">
                <div id="map"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="offer-info"></div>
        </div>
    </div>

@stop