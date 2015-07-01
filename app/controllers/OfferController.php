<?php

class OfferController extends BaseController {

    /**
     * Get form for help offer or request create or edit
     * @require auth
     */
    public function getHelpRequestNew()
    {
        Assets::addJs(array(
            'offer.help-request.js'
        ));

        $user = $this->currentUser;

        $this->layout = View::make(Blind::isEnabled() ? 'app.offer.help-request-new-blind' : 'app.offer.help-request-new',array(
            'user' => $user,
        ));
        $this->layout->title = trans('offer.help-request.title');
    }

    /**
     * Add help offer
     */
    public function getHelpOfferNew()
    {
        $user = $this->currentUser;
        $offer = Offer::where('user_id','=',$user->getId())->where('type','=',2)->first();
        if ($offer && $offer->id) {
            return Redirect::route('helpOfferEditGet',['id'=>$offer->id]);
        }

        Assets::addJs(array(
            'offer.help-offer.js',
        ));

        $this->layout = View::make(Blind::isEnabled() ? 'app.offer.help-offer-new-blind' : 'app.offer.help-offer-new',array(
            'user' => $user,
        ));
        $this->layout->title = trans('offer.help-offer.title');
    }

    /**
     * Edit help offer
     * @param $id
     * @require auth
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getHelpOfferEdit($id)
    {

        $offer = Offer::findOrFail($id);

        if ($offer->type == 1) {
            return Redirect::route('getHelpRequestEdit',['id'=>$id]);
        }

        if ($this->currentUser->getId() !== $offer->user_id && !$this->currentUser->hasAccess('offers-management')) {
            return Response::view('not-found',['title' => trans('global.not-found.title')],404);
        }

        $user = Sentry::findUserById($offer->user_id);
        $daysSaved = $offer->days;
        $days = array();

        if (!empty($daysSaved)) {
            foreach ($daysSaved as $day) {
                $days[$day['day']] = $day;
            }
        }

        Assets::addJs(array(
            'offer.help-offer.js'
        ));

        $this->layout = View::make('app.offer.help-offer-edit',array(
            'user' => $user,
            'offer' => $offer,
            'days' => $days,
        ));
        $this->layout->title = trans('offer.help-offer.edit-title');

    }

    /**
     * Edit help request
     * @param $id
     * @require auth
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getHelpRequestEdit($id)
    {

        $offer = Offer::findOrFail($id);

        if ($offer->type == 2) {
            return Redirect::route('getHelpOfferEdit',['id'=>$id]);
        }

        if ($this->currentUser->getId() !== $offer->user_id && !$this->currentUser->hasAccess('offers-management')) {
            return Response::view('not-found',['title' => trans('global.not-found.title')],404);
        }

        $user = Sentry::findUserById($offer->user_id);

        Assets::addJs(array(
            'offer.help-request.js'
        ));


        $this->layout = View::make('app.offer.help-request-edit',array(
            'user' => $user,
            'offer' => $offer,
        ));
        $this->layout->title = trans('offer.help-request.title');

    }

    /**
     * Create or update new help request or offer
     * @param $id optional
     * @return $this|\Illuminate\Http\RedirectResponse
     * @require auth
     */
    public function postRequest($id = null)
    {
        try {

            if ($id)
            {
                $offer = Offer::findOrFail($id);
                $user = $offer->user;

                if ($user->id !== $this->currentUser->getId() && !$this->currentUser->hasAccess('offers-management'))
                {
                    return Response::view('not-found',['title' => trans('global.not-found.title')],404);
                }

            }
            else
            {
                $user = $this->currentUser;

                if (Input::get('type') == Offer::HELP_REQUEST) {
                    $offer = new Offer();
                    $offer->user_id = $user->getId();
                    $offer->type = Offer::HELP_REQUEST;
                } else {
                    $offer = Offer::firstOrNew(array('user_id'=>$user->getId(),'type'=>Offer::HELP_OFFER));
                }
            }

            if (!$user) {
                return Redirect::route('loginGet');
            }

            $rules = array(
                'first_name' => 'required|min:3|max:255|alpha_dash',
                'last_name' => 'required|min:3|max:255|alpha_dash',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'gender' => 'in:male,female',
                'phone' => 'digits_between:7,16',
                'vk_id' => 'alpha_dash',
//                'birthdate' => 'date_format:Y-m-d',
                'description' => 'required|min:10',
            );
            if (Blind::isEnabled())
            {
                $rules['birthdate.day'] = 'required|date_format:d';
                $rules['birthdate.month'] = 'required|date_format:m';
                $rules['birthdate.year'] = 'required|date_format:Y';
            }
            else
            {
                $rules['birthdate'] = 'date_format:Y-m-d';
            }
            if ($offer->type == Offer::HELP_REQUEST)
            {
                if (Blind::isEnabled())
                {
                    $rules['time.hours'] = 'required|date_format:H';
                    $rules['time.minutes'] = 'required|date_format:i';
                    $rules['date.day'] = 'required|date_format:d';
                    $rules['date.month'] = 'required|date_format:m';
                    $rules['date.year'] = 'required|date_format:Y';
                } else
                {
                    $rules['time'] = 'required|date_format:H:i';
                    $rules['date'] = 'required|date_format:Y-m-d';
                }
            }
            else if ($offer->type == Offer::HELP_OFFER)
            {
                for ($i = 1; $i <= 7; $i++)
                {
                    if (Blind::isEnabled())
                    {
                        $rules['days.'.$i.'.time_start.hours'] = /*'required_if:days.'.$i.'.enabled,1|*/'date_format:H';
                        $rules['days.'.$i.'.time_start.minutes'] = /*'required_if:days.'.$i.'.enabled,1|*/'date_format:i';
                        $rules['days.'.$i.'.time_end.hours'] = /*'required_if:days.'.$i.'.enabled,1|*/'date_format:H';
                        $rules['days.'.$i.'.time_end.minutes'] = /*'required_if:days.'.$i.'.enabled,1|*/'date_format:i';
                    }
                    else
                    {
                        $rules['days.'.$i.'.time_start'] = /*'required_if:days.'.$i.'.enabled,1|*/'date_format:H:i';
                        $rules['days.'.$i.'.time_end'] = /*'required_if:days.'.$i.'.enabled,1|*/'date_format:H:i';
                    }
                }
            }

            $validator = Validator::make(Input::all(),$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $user->email = Input::get('email');
            $user->first_name = (string)Input::get('first_name');
            $user->last_name = (string)Input::get('last_name');
            $user->vk_id = Input::get('vk_id');
            $user->phone = Input::get('phone');
            if (Blind::isEnabled())
            {
                $user->birthdate = Date::createFromDate(Input::get('birthdate.year'),Input::get('birthdate.month'),Input::get('birthdate.day'))->format('Y-m-d');
            }
            else
            {
                $user->birthdate = Input::get('birthdate');
            }
            $user->gender = Input::get('gender');
            $user->address = Input::get('address_longitude') && Input::get('address_longitude') != '0.00000000' ? Input::get('address') : null;
            $user->address_longitude = Input::get('address_longitude') && Input::get('address_longitude') != '0.00000000' ? Input::get('address_longitude') : Config::get('geo.default.lon');
            $user->address_latitude = Input::get('address_latitude') && Input::get('address_latitude') != '0.00000000' ? Input::get('address_latitude') : Config::get('geo.default.lat');
            $user->save();

            $offer->description = Input::get('description');
            if ($offer->type == Offer::HELP_REQUEST)
            {
                $offer->date = Blind::isEnabled() ? Date::createFromDate(Input::get('date.year'),Input::get('date.month'),Input::get('date.day'))->format('Y-m-d') : Input::get('date');
                $offer->time = Blind::isEnabled() ? Date::createFromTime(Input::get('time.hours'), Input::get('time.minutes'))->format('H:i:s') : Date::parse(Input::get('time'))->format('H:i:s');
            }
            $offer->save();

            if ($offer->type == Offer::HELP_OFFER) {
                OfferDays::where('offer_id','=',$offer->id)->delete();
                if (Input::get('days')) {
                    foreach (Input::get('days') as $day => $data) {

                        if (Blind::isEnabled()) {
                            $data['time_start']['hours'] = $data['time_start']['hours'] ? $data['time_start']['hours'] : '09';
                            $data['time_end']['minutes'] = $data['time_end']['minutes'] ? $data['time_end']['minutes'] : '00';
                        } else {
                            $data['time_start'] = $data['time_start'] ? $data['time_start'] : '09:00';
                            $data['time_end'] = $data['time_end'] ? $data['time_end'] : '21:00';
                        }
                        $timeStart = Blind::isEnabled() ? Date::parse($data['time_start']['hours'].':'.$data['time_start']['minutes'])->format('H:i:s') : $data['time_start'];
                        $timeEnd = Blind::isEnabled() ? Date::parse($data['time_end']['hours'].':'.$data['time_end']['minutes'])->format('H:i:s') : $data['time_end'];

                        OfferDays::create(array(
                            'offer_id' => $offer->id,
                            'day' => $day,
                            'time_start' => $timeStart,
                            'time_end' => $timeEnd,
                        ));
                    }
                } else {
                    for ($i = 1; $i <= 7; $i++) {
                        OfferDays::create(array(
                            'offer_id' => $offer->id,
                            'day' => $i,
                            'time_start' => '09:00:00',
                            'time_end' => '21:00:00',
                        ));
                    }
                }
            }

            $offer->index();

//            return Redirect::back()->with('success',trans($offer->type == 1 ? 'offer.help-request.success' : 'offer.help-offer.success'));
            return Redirect::route($offer->type == 1 ? 'helpRequestViewGet' : 'helpOfferViewGet',['id'=>$offer->id]);

        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Ajax action to get offers for map
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffers()
    {

        $helpRequests = Offer::where('type','=',Offer::HELP_REQUEST)
            ->where('date','>=',Date::now()->format('Y-m-d'))
            ->with(array(
                'user' => function($query) {
                    $query->select('id','first_name','last_name','address','address_latitude','address_longitude');
                }
            ))
            ->get();
        $helpOffers = Offer::where('type','=',Offer::HELP_OFFER)
            ->with(array(
                'user' => function($query) {
                    $query->select('id','first_name','last_name','address','address_latitude','address_longitude');
                },
                'days'
            ))->get();

        return Response::json(array(
            'help_requests' => $helpRequests,
            'help_offers' => $helpOffers,
        ));

    }

    /**
     * Ajax action to get offer by id
     * @param $id offer id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffer($id)
    {

        $offer = Offer::findOrFail($id);

        switch ($offer->type) {
            case Offer::HELP_REQUEST:
                return $this->getHelpRequestView($offer->id);
                break;
            case Offer::HELP_OFFER:
                return $this->getHelpOfferView($offer->id);
                break;
        }

    }

    /**
     * List of help requests
     */
    public function getHelpRequests()
    {
        $offers = Offer::where('type','=',Offer::HELP_REQUEST)->where('date','>',Date::now()->format('Y-m-d'))->with('user')->paginate(15);
        $links = $offers->links('pagination');
        $this->layout = View::make('app.offer.help-requests', array(
            'offers' => $offers,
            'links' => $links,
        ));
        $this->layout->title = trans('offer.help-requests.title');
    }

    /**
     * List of help offers
     */
    public function getHelpOffers()
    {
        $offers = Offer::where('type','=',Offer::HELP_OFFER)->with(['user','days'])->paginate(15);
        $links = $offers->links('pagination');
        $this->layout = View::make('app.offer.help-offers', array(
            'offers' => $offers,
            'links' => $links,
        ));
        $this->layout->title = trans('offer.help-offers.title');
    }

    /**
     * Show help request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpRequestView($id)
    {

        $offer = Offer::findOrFail($id);
        $user = $offer->user;

        $showButton = false;
        $showContactInfo = false;
        $hasOfferResponse = false;
        $helpOffer = false;
        $canEdit = false;
        if (Sentry::check())
        {
            $helpOffer = Offer::where('user_id','=',$this->currentUser->getId())->where('type','=',2)->first();
            $hasOfferResponse = !empty($helpOffer) && OfferResponse::where('offer_id','=',$helpOffer->id)->where('request_id','=',$offer->id)->where('status','=',OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE)->count() > 0;
            $showButton = !empty($helpOffer) && !$hasOfferResponse && $this->currentUser->getId() !== $user->id ? true : false;
            $showContactInfo = $hasOfferResponse || $this->currentUser->hasAccess(Config::get('syntara::permissions.listOffers')) || $this->currentUser->getId() === $offer->user_id;
            $canEdit = $offer->user_id == $this->currentUser->getId() || $this->currentUser->hasAccess('offers-management');
        }

        if (Request::ajax())
        {
            $html = View::make('app.offer.help-request-partial', array(
                'offer' => $offer,
                'user' => $user,
                'showButton' => $showButton,
                'showContactInfo' => $showContactInfo,
                'helpOffer' => $helpOffer,
                'hasOfferResponse' => $hasOfferResponse,
                'canEdit' => $canEdit,
            ))->render();
            return Response::json(array(
                'html' => $html,
            ));
        }

        $this->scriptComposer['offerData'] = json_encode(array(
            'lon' => $user->address_longitude,
            'lat' => $user->address_latitude,
        ));

        if (!Blind::isEnabled())
        {
            Assets::addJs(array(
                '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                'offer.help-request-view.js'
            ));
        }

        $this->layout = View::make('app.offer.help-request-view', array(
            'offer' => $offer,
            'user' => $user,
            'showButton' => $showButton,
            'showContactInfo' => $showContactInfo,
            'helpOffer' => $helpOffer,
            'hasOfferResponse' => $hasOfferResponse,
            'canEdit' => $canEdit,
        ));
        $this->layout->title = trans('offer.help-request-view.title');

    }

    /**
     * Show help offer
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHelpOfferView($id)
    {

        $offer = Offer::findOrFail($id);
        $user = $offer->user;
        $days = $offer->days;

        $showButton = false;
        $showContactInfo = false;
        $hasHelpRequest = false;
        $hasOfferResponse = false;
        $helpRequests = false;
        $canEdit = false;
        if (Sentry::check())
        {
            $helpRequests = Offer::where('user_id','=',$this->currentUser->getId())->where('type','=',1)->get();
            $hasHelpRequest = count($helpRequests) > 0;
            $hasOfferResponse = OfferResponse::where('offer_id','=',$offer->id)->where('request_user_id','=',$this->currentUser->getId())->where('status','=',OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE)->count() > 0;
            $showButton = $hasHelpRequest && !$hasOfferResponse && $this->currentUser->getId() !== $user->id ? true : false;
            $showContactInfo = $hasOfferResponse || $this->currentUser->hasAccess(Config::get('syntara::permissions.listOffers')) || $this->currentUser->getId() === $offer->user_id;
            $canEdit = $offer->user_id == $this->currentUser->getId() || $this->currentUser->hasAccess('offers-management');
        }

        if (Request::ajax())
        {
            $html = View::make('app.offer.help-offer-partial', array(
                'offer' => $offer,
                'user' => $user,
                'days' => $days,
                'showButton' => $showButton,
                'showContactInfo' => $showContactInfo,
                'hasHelpRequest' => $hasHelpRequest,
                'hasOfferResponse' => $hasOfferResponse,
                'helpRequests' => $helpRequests,
                'canEdit' => $canEdit,
            ))->render();
            return Response::json(array(
                'html' => $html,
            ));
        }

        if (!Blind::isEnabled())
        {
            Assets::addJs(array(
                '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                'offer.help-offer-view.js'
            ));
        }

        $this->scriptComposer['offerData'] = json_encode(array(
            'lon' => $user->address_longitude,
            'lat' => $user->address_latitude,
        ));

        $this->layout = View::make('app.offer.help-offer-view', array(
            'offer' => $offer,
            'user' => $user,
            'days' => $days,
            'showButton' => $showButton,
            'showContactInfo' => $showContactInfo,
            'hasHelpRequest' => $hasHelpRequest,
            'hasOfferResponse' => $hasOfferResponse,
            'helpRequests' => $helpRequests,
            'canEdit' => $canEdit,
        ));
        $this->layout->title = trans('offer.help-offer-view.title');

    }

    /**
     * Creates response for offer
     *
     * @param $offerId
     * @param $requestId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getResponse($offerId, $requestId)
    {
        $offer = Offer::findOrFail($offerId);
        $request = Offer::findOrFail($requestId);

        // может уже откликался
        $hasOfferResponse = OfferResponse::where('offer_id','=',$offerId)->where('request_id','=',$requestId)->first();

        if ($hasOfferResponse !== null && $hasOfferResponse->status === OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE)
        {
            return Redirect::back()->with('error', trans('offer.already-has-response'));
        }

        OfferResponse::create(array(
            'offer_id' => $offer->id,
            'offer_user_id' => $offer->user_id,
            'request_id' => $request->id,
            'request_user_id' => $request->user_id,
            'initiator_user_id' => $this->currentUser->getId(),
            'status' => OfferResponse::OFFER_RESPONSE_STATUS_ACTIVE,
        ));

        Event::fire('vmeste.createResponse');
//        Statistics::logEvent('createResponse');
        if ($this->currentUser->getId() == $offer->user_id)
        {
            Event::fire('vmeste.createResponseFromOffer');
//            Statistics::logEvent('createResponseFromOffer');
        }
        if ($this->currentUser->getId() == $request->user_id)
        {
            Event::fire('vmeste.createResponseFromRequest');
//            Statistics::logEvent('createResponseFromRequest');
        }

        return Redirect::back()->with('success', trans('offer.response-success'));
    }

    public function postResponse()
    {

        $responseId = Input::get('response_id');

        $validator = Validator::make(Input::only('response_text','response_type'), array(
            'response_text' => 'required|min:1',
            'response_type' => 'required|in:success,canceled'
        ));

        if ($validator->fails())
        {
            return Response::json(array('message' => trans('offer.response.not_empty_text')), 500);
        }

        $offerResponse = OfferResponse::find($responseId);

        if (!$offerResponse || empty($offerResponse))
        {
            return Response::json(array('message' => trans('offer.response.not_found')), 500);
        }

        if ($this->currentUser->getId() !== $offerResponse->offer_user_id && $this->currentUser->getId() !== $offerResponse->request_user_id && !$this->currentUser->hasAccess('response-management'))
        {
            return Response::json(array('message' => trans('offer.response.no_access')), 500);
        }

        if ($this->currentUser->getId() === $offerResponse->offer_user_id)
        {
            $offerResponse->offer_response = Input::get('response_text');
        } else if ($this->currentUser->getId() === $offerResponse->request_user_id)
        {
            $offerResponse->request_response = Input::get('response_text');
        }

        $offerResponse->status = Input::get('response_type') == 'success' ? OfferResponse::OFFER_RESPONSE_STATUS_SUCCESS : OfferResponse::OFFER_RESPONSE_STATUS_CANCELED;
        $offerResponse->save();

        return Response::json(array());

    }

}













