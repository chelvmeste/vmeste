<?php

    class MapController extends BaseController
    {

        /**
         * Home page with map and search
         */
        public function getIndex()
        {
            if (!Blind::isEnabled())
            {
                Assets::addCss(array(
                    'bootstrap-datetimepicker.min.css'
                ));

                Assets::addJs(array(
                    'moment.js',
                    'moment.ru.js',
                    'bootstrap-datetimepicker.min.js',
                    'mustache.js',
                    'template.js',
                    '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                    'map.js',
                    'search.js',
                    'map.index.js'
                ));
            }

            $data = array();

            // get responses
            $data['offerResponses'] = Sentry::check() ? OfferResponse::whereRaw('status = ? AND (offer_user_id = ? OR request_user_id = ?)', [OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE, $this->currentUser->getId(), $this->currentUser->getId()])->get() : array();

            if (Blind::isEnabled())
            {

                if (Sentry::check() && $this->currentUser->address_longitude !== null)
                {

                    $data['requests'] = $this->getUserClosestRequests();
                    $data['offers'] = $this->getUserClosestOffers();

                }
                else
                {
                    $data['offers'] = Offer::where('type','=',Offer::HELP_OFFER)->with(['user','days'])->limit(10)->get();
                    $data['requests'] = Offer::where('type','=',Offer::HELP_REQUEST)->where('date','>',Date::now()->format('Y-m-d'))->with('user')->limit(10)->get();
                }

            }

            $this->layout = View::make(Blind::isEnabled() ? 'app.home.index-blind' : 'app.home.index', $data);
            $this->layout->title = trans('map.title');

        }

        protected function getUserClosestRequests()
        {

            $offer = Offer::where('type','=',Offer::HELP_OFFER)->where('user_id','=',$this->currentUser->getId())->first();

            $query = new Elastica\Query();
            $queryFilter = new \Elastica\Filter\BoolAnd();

            // set type to requests
            $filterOfferType = new Elastica\Filter\Term();
            $filterOfferType->setTerm('type',Offer::HELP_REQUEST);
            $queryFilter->addFilter($filterOfferType);

            if (isset($offer->id))
            {
                if ($offer->days)
                {
                    $daysFilter = new Elastica\Filter\BoolOr();
                    foreach($offer->days as $day)
                    {
                        $filterTime = new Elastica\Filter\Range();
                        $filterTime->addField('time', array(
                            'lte' => $day->time_start,
                        ));
                        $queryFilter->addFilter($filterTime);
                        $filterTime = new Elastica\Filter\Range();
                        $filterTime->addField('time', array(
                            'gte' => $day->time_start,
                        ));

                        $daysFilter->addFilter($filterTime);

                    }
                    $queryFilter->addFilter($daysFilter);
                }

            }

            $distanceFilter = new Elastica\Filter\GeoDistance('user.location', array('lat' => $this->currentUser->address_latitude, 'lon' => $this->currentUser->address_longitude),'30km');
            $queryFilter->addFilter($distanceFilter);

            $query->setPostFilter($queryFilter);
            $rawQuery = $query->toArray();

            $results = Offer::search($rawQuery);

            $results->load(array(
                'user' => function($query) {
                    $query->select('id','first_name','last_name','address','address_latitude','address_longitude');
                }
            ));

            return $results;

        }

        protected function getUserClosestOffers()
        {

            $requests = Offer::where('type','=',Offer::HELP_REQUEST)->where('user_id','=',$this->currentUser->getId())->get();

            $query = new Elastica\Query();
            $queryFilter = new \Elastica\Filter\BoolAnd();

            // set type to offers
            $filterOfferType = new Elastica\Filter\Term();
            $filterOfferType->setTerm('type',Offer::HELP_OFFER);
            $queryFilter->addFilter($filterOfferType);

            if ($requests && count($requests) > 0) {
                foreach ($requests as $request) {
                    $day = Date::parse($request->date)->format('N');

                    $filterDateTime = new Elastica\Filter\BoolAnd();

                    $filterDay = new Elastica\Filter\Term();
                    $filterDay->setTerm('days.day_' . $day . '.active', true);
                    $filterDateTime->addFilter($filterDay);

                    $filterTime = new Elastica\Filter\Range();
                    $filterTime->addField('days.day_' . $day . '.time_start', array(
                        'lte' => $request->time,
                    ));
                    $filterDateTime->addFilter($filterTime);
                    $filterTime = new Elastica\Filter\Range();
                    $filterTime->addField('days.day_' . $day . '.time_end', array(
                        'gte' => $request->time,
                    ));
                    $filterDateTime->addFilter($filterTime);

                    $queryFilter->addFilter($filterDateTime);
                }
            }

            $distanceFilter = new Elastica\Filter\GeoDistance('user.location', array('lat' => $this->currentUser->address_latitude, 'lon' => $this->currentUser->address_longitude),'30km');
            $queryFilter->addFilter($distanceFilter);

            $query->setPostFilter($queryFilter);
            $rawQuery = $query->toArray();

            $results = Offer::search($rawQuery);

            $results->load(array(
                'user',
                'days'
            ));

            return $results;

        }

    }
