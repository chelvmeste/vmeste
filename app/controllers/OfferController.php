<?php

class OfferController extends BaseController {

    /**
     * Get form for help offer or request create or edit
     * @require auth
     */
    public function getHelpRequest()
    {
        Assets::addCss(array(
            'bootstrap-datetimepicker.min.css'
        ));

        Assets::addJs(array(
            'moment.js',
            'moment.ru.js',
            'bootstrap-datetimepicker.min.js',
            'offer.help-request.js'
        ));

        $user = Sentry::getUser();
        $offer = Offer::firstOrNew(array('user_id'=>$user->getId(),'type'=>1));

        $this->layout = View::make('app.offer.help-request',array(
            'user' => $user,
            'offer' => $offer,
        ));
        $this->layout->title = trans('offer.help-request.title');
    }

    /**
     * Create or update new help request or offer
     * @return $this|\Illuminate\Http\RedirectResponse
     * @require auth
     */
    public function postRequest()
    {
        try {

            $user = Sentry::getUser();
            $offer = Offer::firstOrNew(array('user_id'=>$user->getId(),'type'=>Input::get('type')));

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
            if (Input::exists('vk_id'))
            {
                $user->vk_id = Input::get('vk_id');
            }
            if (Input::exists('phone'))
            {
                $user->phone = Input::get('phone');
            }
            if (Input::exists('birthdate'))
            {
                $user->birthdate = Input::get('birthdate');
            }
            if (Input::exists('gender'))
            {
                $user->gender = Input::get('gender');
            }
            if (Input::exists('address') && Input::exists('address_longitude') && Input::exists('address_latitude'))
            {
                $user->address = Input::get('address');
                $user->address_longitude = Input::get('address_longitude');
                $user->address_latitude = Input::get('address_latitude');
            }
            $user->save();

            $offer->description = Input::get('description');
            if (Input::exists('date'))
            {
                $offer->date = Input::get('date');
            }
            $offer->time = Input::get('time');
            $offer->save();

            return Redirect::back()->with('success',trans($offer->type == 1 ? 'offer.help-request.success' : 'offer.help-offer.success'));

        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Add help offer
     */
    public function getHelpOffer()
    {
        Assets::addCss(array(
            'bootstrap-datetimepicker.min.css'
        ));

        Assets::addJs(array(
            'moment.js',
            'moment.ru.js',
            'bootstrap-datetimepicker.min.js',
            'offer.help-offer.js'
        ));

        $user = Sentry::getUser();
        $offer = Offer::firstOrNew(array('user_id'=>$user->getId(),'type'=>2));

        $this->layout = View::make('app.offer.help-offer',array(
            'user' => $user,
            'offer' => $offer,
        ));
        $this->layout->title = trans('offer.help-offer.title');
    }

    /**
     * Ajax action to get offers for map
     * @todo set columns
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
        $offers = Offer::where('type','=',1)->with('user')->paginate(15);
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
        $offers = Offer::where('type','=',2)->with('user')->paginate(15);
        $links = $offers->links();
        $this->layout = View::make('app.offer.help-offers', array(
            'offers' => $offers,
            'links' => $links,
        ));
        $this->layout->title = trans('offer.help-offers.title');
    }

}













