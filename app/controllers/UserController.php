<?php

//use MrJuliuss\Syntara\Services\Validators\User as UserValidator;

    class UserController extends BaseController
    {

        public function getRegisterComplete()
        {
//            if (URL::previous() != URL::route('registerGet')) {
            if (URL::previous() != URL::route('loginGet')) {
                Redirect::route('homeGet');
            }

            $this->layout = View::make('app.user.register-complete');
            $this->layout->title = trans('user.register.success_title');
        }

        public function getLogin()
        {
            $this->layout = View::make('app.user.login');
            $this->layout->title = trans('user.login.title');
        }

        public function postLogin()
        {
            try
            {
                $validator = Validator::make(Input::all(),array(
                    'email' => 'required|email',
                    'password' => 'required|min:6|max:255'
                ));

                if($validator->fails())
                {
                    return Redirect::back()->withErrors($validator);
                }

                $credentials = array(
                    'email' => Input::get('email'),
                    'password' => Input::get('password'),
                );

                Sentry::authenticate($credentials, (bool)Input::get('remember'));

                return Redirect::intended(URL::route('homeGet'));

            } catch(\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                return Redirect::back()->withErrors([trans('syntara::all.messages.banned')]);
            } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Redirect::back()->withErrors([trans('user.login.invalid_password')]);
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {

                $user = Sentry::getUserProvider()->create($credentials);

                $activationCode = $user->getActivationCode();

                $data = array(
                    'code' => $activationCode,
                    'email' => Input::get('email'),
                    'password' => Input::get('password'),
                );

                // send email
                Mail::queue(Config::get('syntara::mails.user-activation-view'), $data, function($message) use ($user) {
                    $message->from(Config::get('syntara::mails.email'), Config::get('syntara::mails.contact'))
                        ->subject(Config::get('syntara::mails.user-activation-object'));
                    $message->to($user->getLogin());
                });

                return Redirect::route('registerComplete');

            }

        }

        public function getLogout()
        {
            Sentry::logout();

            return Redirect::route('homeGet');
        }

        public function getActivate($activationCode)
        {
            try
            {
                $user = Sentry::getUserProvider()->findByActivationCode($activationCode);

                if($user->attemptActivation($activationCode))
                {
                    $message = trans('user.activate.success');
                }
                else
                {
                    $message = trans('user.activate.failed');
                }
            }
            catch(\Exception $e)
            {
                $message = trans('user.activate.failed');
            }

            $this->layout = View::make('app.user.activate',array(
                'message' => $message,
            ));
            $this->layout->title = trans('user.activate.title');
        }

        public function getEditProfile()
        {
            $user = Sentry::getUser();

            Assets::addCss(array(
                'bootstrap-datetimepicker.min.css'
            ));

            Assets::addJs(array(
                'moment.js',
                'moment.ru.js',
                'bootstrap-datetimepicker.min.js',
                'typeahead.bundle.js',
//                'geocoder.js',
                'user.edit-profile.js'
            ));

            $this->layout = View::make('app.user.edit-profile',array(
                'user' => $user,
            ));
            $this->layout->title = trans('user.edit-profile.title');
        }

        public function postEditProfile()
        {
            try {

                $user = Sentry::getUser();

                if (!$user) {
                    return Redirect::route('loginGet');
                }

                $rules = array(
                    'first_name' => 'required|min:3|max:255|alpha_dash',
                    'last_name' => 'required|min:3|max:255|alpha_dash',
//                    'username' => 'required|min:3|max:255|alpha_dash|unique:users,username,'.$user->id,
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'gender' => 'in:male,female',
                    'phone' => 'digits_between:7,16',
                    'vk_id' => 'alpha_dash',
//                    'birthdate' => 'date_format:Y-m-d',
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

//                if (Input::get('password')) {
//                    $rules['password'] = 'required|min:6|max:255|confirmed';
//                }

                $validator = Validator::make(Input::all(),$rules);

                if ($validator->fails()) {

                    return Redirect::back()->withInput()->withErrors($validator);

                }

                $user->email = Input::get('email');
//                $user->username = Input::get('username');
                $user->first_name = (string)Input::get('first_name');
                $user->last_name = (string)Input::get('last_name');
//                if (Input::get('password')) {
//                    $user->password = Input::get('password');
//                }
                if (Input::exists('vk_id')) {
                    $user->vk_id = Input::get('vk_id');
                }
                if (Input::exists('phone')) {
                    $user->phone = Input::get('phone');
                }
                if (Input::exists('birthdate')) {
//                    $user->birthdate = Input::get('birthdate');
                    if (Blind::isEnabled())
                    {
                        $user->birthdate = Date::createFromDate(Input::get('birthdate.year'),Input::get('birthdate.month'),Input::get('birthdate.day'))->format('Y-m-d');
                    }
                    else
                    {
                        $user->birthdate = Input::get('birthdate');
                    }
                }
                if (Input::exists('gender')) {
                    $user->gender = Input::get('gender');
                }
                if (Input::exists('address') && Input::exists('address_longitude') && Input::exists('address_latitude')) {
                    $user->address = Input::get('address');
                    $user->address_longitude = Input::get('address_longitude');
                    $user->address_latitude = Input::get('address_latitude');
                }
                $user->save();

                return Redirect::back()->with('success',trans('user.edit-profile.success'));

            } catch (Exception $e) {
                return Redirect::back()->withErrors([$e->getMessage()]);
            }

        }

        public function getProfile($id)
        {
            $user = User::findOrFail($id);
            $helpRequest = Offer::where('user_id','=',$id)->where('type','=',1)->first();
            $helpOffer = Offer::where('user_id','=',$id)->where('type','=',2)->first();

            $this->layout = View::make('app.user.profile', array(
                'user' => $user,
                'help_request' => $helpRequest,
                'help_offer' => $helpOffer,
            ));
            $this->layout->title = trans('user.profile.title', ['name' => !empty($user->first_name) ? $user->first_name . ' ' . $user->last_name : '']);
        }

    }
