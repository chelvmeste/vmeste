@extends('layouts.app.layout')
@section('content')

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
                                    'address' => $response->requestUser->address ? $response->requestUser->address : trans('offer.no-address'),
                                    'phone' => $response->requestUser->phone ? $response->requestUser->phone : trans('offer.no-phone'),
                                    'vk_id' => $response->requestUser->vk_id ? trans('offer.vk_link', ['vk_id' => $response->requestUser->vk_id]) : '',
                                ]) }}
                            @else
                                {{-- 2 - ко мне обратились за помощью --}}
                                {{ trans('offer.response.2-somebody-request-help', [
                                    'username' => $response->requestUser->first_name.' '.$response->requestUser->last_name,
                                    'requestLink' => URL::route('helpRequestViewGet', ['id' => $response->request_id]),
                                    'address' => $response->requestUser->address ? $response->requestUser->address : trans('offer.no-address'),
                                    'phone' => $response->requestUser->phone ? $response->requestUser->phone : trans('offer.no-phone'),
                                    'vk_id' => $response->requestUser->vk_id ? trans('offer.vk_link', ['vk_id' => $response->requestUser->vk_id]) : '',
                                ]) }}
                            @endif
                        @elseif($response->request_user_id === $currentUser->getId())
                            @if($response->request_user_id === $response->initiator_user_id)
                                {{-- 3 - вы попросили о помощи --}}
                                {{ trans('offer.response.3-you-request-help', [
                                    'address' => $response->offerUser->address ? $response->offerUser->address : trans('offer.no-address'),
                                    'phone' => $response->offerUser->phone ? $response->offerUser->phone : trans('offer.no-phone'),
                                    'vk_id' => $response->offerUser->vk_id ? trans('offer.vk_link', ['vk_id' => $response->offerUser->vk_id]) : '',
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
                                    'address' => $response->offerUser->address ? $response->offerUser->address : trans('offer.no-address'),
                                    'phone' => $response->offerUser->phone ? $response->offerUser->phone : trans('offer.no-phone'),
                                    'vk_id' => $response->offerUser->vk_id ? trans('offer.vk_link', ['vk_id' => $response->offerUser->vk_id]) : '',
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

    <form id="search-offers-form">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="gender">{{ trans('global.gender') }}</label>
                    <div class="input-group full-width">
                        <select name="gender" class="js-select offers-search-filter">
                            <option value="any">{{ trans('global.any') }}</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="day">{{ trans('global.day') }}</label>
                    <div class="input-group full-width">
                        <select name="day" class="js-select offers-search-filter">
                            <option value="any">{{ trans('global.any') }}</option>
                            @for($i=1;$i<=7;$i++)
                                <option value="day_{{ $i }}">{{ trans('global.days.'.$i) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="time">{{ trans('global.time') }}</label>
                    <div class="input-group full-width offer-time" id="offer-time">
                        <input type="text" class="form-control offers-search-filter" name="time" id="time" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <a class="btn btn-warning active search-switch show-requests">
                    Показать только нуждающихся
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <a class="btn btn-warning search-switch show-offers">
                    Показать только Добровольцев
                </a>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-12">
            <div class="map" id="map"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div id="offer-info"></div>
        </div>
    </div>

    {{--<div class="rotation">

            <div class="form-row text-justify">
                <div class="form-inline third">
                    <label for="gender">{{ trans('global.gender') }}</label>
                    <select name="gender" class="select offers-search-filter">
                        <option value="any">{{ trans('global.any') }}</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-inline third">
                    <label for="day">{{ trans('global.day') }}</label>
                    <select name="day" class="select offers-search-filter">
                        <option value="any">{{ trans('global.any') }}</option>
                        @for($i=1;$i<=7;$i++)
                            <option value="day_{{ $i }}">{{ trans('global.days.'.$i) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-inline-time third">
                    <label for="time">{{ trans('global.time') }}</label>
                    <div class="input-group offer-time" id="offer-time">
                        <input type="text" class="form-control offers-search-filter" name="time" id="time" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="map-buttons">
                <div class="button only-need-but bt-active search-switch show-requests" >
                    Показать только нуждающихся
                </div>
                <div class="button only-volunteer-but search-switch show-offers" >
                    Показать только Добровольцев
                </div>
            </div>
        </form>
        <div id="side-list"></div>
        <div class="map" id="map"></div>
    </div>
    <div class="clear"></div>
    <div id="offer-info"></div>--}}

@stop
