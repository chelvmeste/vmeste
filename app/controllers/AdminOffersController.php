<?php

use MrJuliuss\Syntara\Controllers\BaseController;

    class AdminOffersController extends BaseController {

        public function getOffers()
        {

            $offers = Offer::where('type','=',Offer::HELP_OFFER)->paginate(Config::get('syntara::config.item-perge-page'));
            $links = $offers->links('pagination::slider');

            $datas = array(
                'offers' => $offers,
                'links' => $links,
            );

            if (Request::ajax()) {
                $html = View::make('admin.offers.offers-list',$datas)->render();
                return Response::json(array('html'=>$html));
            }

            $this->layout = View::make('admin.offers.offers-index', $datas);
            $this->layout->title = trans('admin.navigation.offers.offers');
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('admin.navigation.offers.offers'),
                    'link' => URL::route('getAdminOffers'),
                    'icon' => 'glyphicon-file'
                ),
            );

        }

        public function showAdminOffer($id)
        {

            $offer = Offer::findOrFail($id);

            $user = $offer->user;
            $daysSaved = $offer->days;
            $days = array();

            if (!empty($daysSaved)) {
                foreach ($daysSaved as $day) {
                    $days[$day['day']] = $day;
                }
            }

            $datas = array(
                'user' => $user,
                'offer' => $offer,
                'days' => $days,
                'geoConfig' => json_encode(Config::get('geo')),
            );

            $this->layout = View::make('admin.offers.offer-edit', $datas);
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('admin.navigation.offers.offers'),
                    'link' => URL::route('getAdminOffers'),
                    'icon' => 'glyphicon-file'
                ),
                array(
                    'title' => trans('admin.navigation.offers.offer-edit'),
                    'link' => URL::route('showAdminOffer', ['id' => $id]),
                    'icon' => 'glyphicon-pencil'
                ),
            );


        }

        public function putAdminOffer($id)
        {

            try {

                $offer = Offer::findOrFail($id);

                $user = $offer->user;

                $rules = array(
                    'first_name' => 'required|min:3|max:255|alpha_dash',
                    'last_name' => 'required|min:3|max:255|alpha_dash',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'gender' => 'in:male,female',
                    'phone' => 'digits_between:7,16',
                    'vk_id' => 'alpha_dash',
                    'birthdate' => 'date_format:Y-m-d',
                    'description' => 'required|min:10',
                );
                for ($i = 1; $i <= 7; $i++) {
                    $rules['days.'.$i.'.time_start'] = 'required_if:days.'.$i.'.enabled,1|date_format:H:i';
                    $rules['days.'.$i.'.time_end'] = 'required_if:days.'.$i.'.enabled,1|date_format:H:i';
                }

                $validator = Validator::make(Input::all(),$rules);

                if ($validator->fails())
                {
                    return Response::json(array('saved' => false, 'errorMessages' => $validator->errors(), 'messageType' => 'danger'));
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

                $offer->save();

                OfferDays::where('offer_id','=',$offer->id)->delete();
                foreach (Input::get('days') as $day => $data) {
                    OfferDays::create(array(
                        'offer_id' => $offer->id,
                        'day' => $day,
                        'time_start' => $data['time_start'],
                        'time_end' => $data['time_end'],
                    ));
                }

                return Response::json(array('saved' => true, 'redirectUrl' => URL::route('getAdminOffers')));

            } catch (Exception $e) {
                return Response::json(array('saved' => false, 'message' => $e->getMessage(), 'messageType' => 'danger'));
            }

        }

        public function deleteAdminOffer($id)
        {

            try {

                Offer::destroy($id);

                return Response::json(array('deleted' => true, 'message' => trans('admin.deleted'), 'messageType' => 'success'));

            } catch (Exception $e) {
                return Response::json(array('deleted' => false, 'message' => $e->getMessage(), 'messageType' => 'danger'));
            }

        }

        public function getRequests()
        {

            $offers = Offer::where('type','=',Offer::HELP_REQUEST)->paginate(Config::get('syntara::config.item-perge-page'));
            $links = $offers->links();

            $datas = array(
                'offers' => $offers,
                'links' => $links,
            );

            if (Request::ajax()) {
                $html = View::make('',$datas)->render();
                return Response::json(array('html'=>$html));
            }

            $this->layout = View::make('admin.offers.requests-index', $datas);
            $this->layout->title = trans('admin.navigation.offers.requests');
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('admin.navigation.offers.requests'),
                    'link' => URL::route('getAdminRequests'),
                    'icon' => 'glyphicon-file'
                ),
            );

        }

        public function showAdminRequest($id)
        {

            $offer = Offer::findOrFail($id);
            $user = $offer->user;

            $datas = array(
                'user' => $user,
                'offer' => $offer,
                'geoConfig' => json_encode(Config::get('geo')),
            );

            $this->layout = View::make('admin.offers.request-edit', $datas);
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('admin.navigation.offers.requests'),
                    'link' => URL::route('getAdminRequests'),
                    'icon' => 'glyphicon-file'
                ),
                array(
                    'title' => trans('admin.navigation.offers.request-edit'),
                    'link' => URL::route('showAdminRequest', ['id' => $id]),
                    'icon' => 'glyphicon-pencil'
                ),
            );

        }

        public function putAdminRequest($id)
        {

            try {

                $offer = Offer::findOrFail($id);
                $user = $offer->user;

                $rules = array(
                    'first_name' => 'required|min:3|max:255|alpha_dash',
                    'last_name' => 'required|min:3|max:255|alpha_dash',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'gender' => 'in:male,female',
                    'phone' => 'digits_between:7,16',
                    'vk_id' => 'alpha_dash',
                    'birthdate' => 'date_format:Y-m-d',
                    'description' => 'required|min:10',
                );
                $rules['time'] = 'required|date_format:H:i';
                $rules['date'] = 'required|date_format:Y-m-d';

                $validator = Validator::make(Input::all(),$rules);

                if ($validator->fails())
                {
                    return Response::json(array('saved' => false, 'errorMessages' => $validator->errors(), 'messageType' => 'danger'));
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
                $offer->date = Input::get('date');
                $offer->time = Input::get('time');
                $offer->save();

                return Response::json(array('saved' => true, 'redirectUrl' => URL::route('getAdminRequests')));

            } catch (Exception $e) {
                return Response::json(array('saved' => false, 'message' => $e->getMessage(), 'messageType' => 'danger'));
            }

        }

        public function getResponses()
        {

            $offerResponses = new OfferResponse();

            $responseStatus = Input::get('status');
            if ($responseStatus)
            {
                $offerResponses = $offerResponses->where('status','=',$responseStatus);
            }

            $offerResponses = $offerResponses->orderBy('created_at','desc')->paginate(Config::get('syntara::config.item-perge-page'));
            $links = $offerResponses->links();

            $datas = array(
                'offerResponses' => $offerResponses,
                'links' => $links,
            );

            if (Request::ajax())
            {
                $html = View::make('admin.offers.responses-list',$datas)->render();
                return Response::json(array('html'=>$html));
            }

            $this->layout = View::make('admin.offers.responses-index', $datas);
            $this->layout->title = trans('admin.navigation.offers.responses');
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('admin.navigation.offers.responses'),
                    'link' => URL::route('getAdminResponses'),
                    'icon' => 'glyphicon-file'
                ),
            );

        }

        public function showAdminResponse($id)
        {

            $response = OfferResponse::findOrFail($id);
            $offerUser = $response->offerUser;
            $requestUser = $response->requestUser;

            $datas = array(
                'response' => $response,
                'offerUser' => $offerUser,
                'requestUser' => $requestUser,
            );

            $this->layout = View::make('admin.offers.response-view', $datas);
            $this->layout->title = trans('admin.offers.response-view');
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('admin.navigation.offers.responses'),
                    'link' => URL::route('getAdminResponses'),
                    'icon' => 'glyphicon-file'
                ),
                array(
                    'title' => trans('admin.navigation.offers.response-view'),
                    'link' => URL::route('showAdminResponse', ['id' => $id]),
                    'icon' => 'glyphicon-pencil'
                ),
            );

        }

        public function putAdminResponse($id)
        {

            try {

                $response = OfferResponse::findOrFail($id);

                $response->offer_response = Input::get('offer_response');
                $response->request_response = Input::get('request_response');
                $response->status = Input::get('status');
                $response->save();

                return Response::json(array('saved' => true, 'redirectUrl' => URL::route('getAdminResponses')));

            } catch (Exception $e) {
                return Response::json(array('saved' => false, 'message' => $e->getMessage(), 'messageType' => 'danger'));
            }

        }

        public function deleteAdminResponse($id)
        {

            try {

                OfferResponse::destroy($id);

                return Response::json(array('deleted' => true, 'message' => trans('admin.deleted'), 'messageType' => 'success'));

            } catch (Exception $e) {
                return Response::json(array('deleted' => false, 'message' => $e->getMessage(), 'messageType' => 'danger'));
            }

        }

    }