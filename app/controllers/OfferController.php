<?php

class OfferController extends BaseController {

    /**
     * Get form for help offer or request create or edit
     * @require auth
     */
    public function getHelpRequestNew()
    {
        Assets::addCss(array(
            'bootstrap-datetimepicker.min.css'
        ));

        Assets::addJs(array(
            'moment.js',
            'moment.ru.js',
            'bootstrap-datetimepicker.min.js',
            'typeahead.bundle.js',
            'offer.help-request.js'
        ));

        $user = $this->currentUser;

        $this->layout = View::make('app.offer.help-request-new',array(
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

        Assets::addCss(array(
            'bootstrap-datetimepicker.min.css'
        ));

        Assets::addJs(array(
            'moment.js',
            'moment.ru.js',
            'bootstrap-datetimepicker.min.js',
            'typeahead.bundle.js',
            'offer.help-offer.js'
        ));

        $this->layout = View::make('app.offer.help-offer',array(
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

        if ($this->currentUser->getId() !== $offer->user_id && !$this->currentUser->hasPermission('editHelpOffer')) {
            return Response::view('not-found',['title' => trans('global.not-found.title')],404);
        }

        $user = Sentry::findUserById($offer->user_id);

        Assets::addCss(array(
            'bootstrap-datetimepicker.min.css'
        ));

        Assets::addJs(array(
            'moment.js',
            'moment.ru.js',
            'bootstrap-datetimepicker.min.js',
            'typeahead.bundle.js',
            'offer.help-offer.js'
        ));

        $this->layout = View::make('app.offer.help-offer-edit',array(
            'user' => $user,
            'offer' => $offer,
        ));
        $this->layout->title = trans('offer.help-offer.edit-title');

    }

    /**
     * Create or update new help request or offer
     * @return $this|\Illuminate\Http\RedirectResponse
     * @require auth
     */
    public function postRequest()
    {
        try {

            // todo check when add $id as param
            $user = $this->currentUser;

            if (Input::get('type') == 1) {
                $offer = new Offer();
                $offer->user_id = $user->getId();
                $offer->type = Input::get('type');
            } else {
                $offer = Offer::firstOrNew(array('user_id'=>$user->getId(),'type'=>2));
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
                'birthdate' => 'date_format:Y-m-d',
                'description' => 'required|min:10',
                'time' => 'required|date_format:H:i',
            );
            if ($offer->type === 1)
            {
                $rules['date'] = 'required|date_format:Y-m-d';
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
            $user->birthdate = Input::get('birthdate');
            $user->gender = Input::get('gender');
            $user->address = Input::get('address');
            $user->address_longitude = Input::get('address_longitude');
            $user->address_latitude = Input::get('address_latitude');
            $user->save();

            $offer->description = Input::get('description');
            if ($offer->type == 1)
            {
                $offer->date = Input::get('date');
            }
            $offer->time = Input::get('time');
            $offer->save();

//            return Redirect::back()->with('success',trans($offer->type == 1 ? 'offer.help-request.success' : 'offer.help-offer.success'));
            return Redirect::route($offer->type == 1 ? 'helpRequestViewGet' : 'helpOfferViewGet',['id'=>$offer->id]);

        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Ajax action to get offers for map
     * @todo set columns
     * @todo migrate to elasticsearch
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffers()
    {

        $offers = Offer::with('user')->get();

        return Response::json(array(
            'offers' => $offers
        ));

    }

    /**
     * List of help requests
     */
    public function getHelpRequests()
    {
        $offers = Offer::where('type','=',Offer::HELP_REQUEST)->where('date','>',Date::now()->format('Y-m-d'))->with('user')->paginate(15);
        $links = $offers->links();
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
        $offers = Offer::where('type','=',Offer::HELP_OFFER)->with('user')->paginate(15);
        $links = $offers->links();
        $this->layout = View::make('app.offer.help-offers', array(
            'offers' => $offers,
            'links' => $links,
        ));
        $this->layout->title = trans('offer.help-offers.title');
    }

    /**
     * Show help request
     *
     * @param $id
     */
    public function getHelpRequestView($id)
    {

        $offer = Offer::findOrFail($id);
        $user = $offer->user;

        Assets::addJs(array(
            '//api-maps.yandex.ru/2.1/?lang=ru_RU',
            'map.js',
            'offer.help-request-view.js'
        ));

        $showButton = false;
        $showContactInfo = false;
        $hasOfferResponse = false;
        $helpOffer = false;
        if (Sentry::check())
        {
            $helpOffer = Offer::where('user_id','=',$this->currentUser->getId())->where('type','=',2)->first();
            $hasOfferResponse = OfferResponse::where('offer_id','=',$helpOffer->id)->where('request_id','=',$offer->id)->count() > 0;
            $showButton = !empty($helpOffer) && !$hasOfferResponse && $this->currentUser->getId() !== $user->id ? true : false;
            $showContactInfo = $hasOfferResponse || $this->currentUser->hasAccess(Config::get('syntara::permissions.listOffers')) || $this->currentUser->getId() === $offer->user_id;
        }

        $this->scriptComposer['offerData'] = json_encode(array(
            'lon' => $user->address_longitude,
            'lat' => $user->address_latitude,
        ));

        $this->layout = View::make('app.offer.help-request-view', array(
            'offer' => $offer,
            'user' => $user,
            'showButton' => $showButton,
            'showContactInfo' => $showContactInfo,
            'helpOffer' => $helpOffer,
            'hasOfferResponse' => $hasOfferResponse,
        ));
        $this->layout->title = trans('offer.help-request-view.title');

    }

    /**
     * Show help offer
     *
     * @param $id
     */
    public function getHelpOfferView($id)
    {

        $offer = Offer::findOrFail($id);
        $user = $offer->user;

        Assets::addJs(array(
            '//api-maps.yandex.ru/2.1/?lang=ru_RU',
            'map.js',
            'offer.help-offer-view.js'
        ));

        $showButton = false;
        $showContactInfo = false;
        $hasHelpRequest = false;
        $hasOfferResponse = false;
        $helpRequests = false;
        if (Sentry::check())
        {
            $helpRequests = Offer::where('user_id','=',$this->currentUser->getId())->where('type','=',1)->get();
            $hasHelpRequest = count($helpRequests) > 0;
            $hasOfferResponse = OfferResponse::where('offer_id','=',$offer->id)->where('request_user_id','=',$this->currentUser->getId())->count() > 0;
            $showButton = $hasHelpRequest && !$hasOfferResponse && $this->currentUser->getId() !== $user->id ? true : false;
            $showContactInfo = $hasOfferResponse || $this->currentUser->hasAccess(Config::get('syntara::permissions.listOffers')) || $this->currentUser->getId() === $offer->user_id;
        }

        $this->scriptComposer['offerData'] = json_encode(array(
            'lon' => $user->address_longitude,
            'lat' => $user->address_latitude,
        ));

        $this->layout = View::make('app.offer.help-offer-view', array(
            'offer' => $offer,
            'user' => $user,
            'showButton' => $showButton,
            'showContactInfo' => $showContactInfo,
            'hasHelpRequest' => $hasHelpRequest,
            'hasOfferResponse' => $hasOfferResponse,
            'helpRequests' => $helpRequests,
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
        $hasOfferResponse = OfferResponse::where('offer_id','=',$offerId)->where('request_id','=',$requestId)->count() > 0;

        if ($hasOfferResponse)
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

        if ($this->currentUser->getId() !== $offerResponse->offer_user_id && $this->currentUser->getId() !== $offerResponse->request_user_id && !$this->currentUser->hasAccess('editResponse'))
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













