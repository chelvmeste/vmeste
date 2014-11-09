<?php

    class MapController extends BaseController
    {

        /**
         * Home page with map and search
         */
        public function getIndex()
        {

            Assets::addJs(array(
                '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                'map.js',
                'map.index.js'
            ));

            // get responses
            $offerResponses = Sentry::check() ? OfferResponse::where('offer_user_id','=',$this->currentUser->getId())->orWhere('request_user_id','=',$this->currentUser->getId())->where('status','=',OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE)->get() : array();

            $this->layout = View::make('app.home.index', array(
                'offerResponses' => $offerResponses,
            ));
            $this->layout->title = trans('map.title');

        }

    }