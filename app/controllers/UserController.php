<?php

//use MrJuliuss\Syntara\Services\Validators\User as UserValidator;

    class UserController extends BaseController
    {

        public function getRegister()
        {

            $this->layout = View::make('app.user.register');
            $this->layout->title = trans('user.register.title');

        }

        public function postRegister()
        {

            try {

                $validator = Validator::make(Input::all(),array(
                    'first_name' => 'required|min:3|max:255|alpha_dash',
                    'last_name' => 'required|min:3|max:255|alpha_dash',
                    'username' => 'required|min:3|max:255|alpha_dash|unique:users',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|max:255|confirmed',
                ));

                if ($validator->fails()) {

                    return Redirect::back()->withInput()->withErrors($validator);

                }

                $user = Sentry::getUserProvider()->create(array(
                    'email'    => Input::get('email'),
                    'password' => Input::get('password'),
                    'username' => Input::get('username'),
                    'last_name' => (string)Input::get('last_name'),
                    'first_name' => (string)Input::get('first_name')
                ));

                $activationCode = $user->getActivationCode();

                $data = array(
                    'code' => $activationCode,
                    'username' => $user->username
                );

                // send email
                Mail::queue(Config::get('syntara::mails.user-activation-view'), $data, function($message) use ($user) {
                    $message->from(Config::get('syntara::mails.email'), Config::get('syntara::mails.contact'))
                        ->subject(Config::get('syntara::mails.user-activation-object'));
                    $message->to($user->getLogin());
                });

                return Redirect::route('registerComplete');

            } catch (Exception $e) {
                return Redirect::back()->withErrors([$e->getMessage()]);
            }

        }

        public function getRegisterComplete()
        {

            if (URL::previous() != URL::route('registerGet')) {
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

                $loginAttribute = Config::get('cartalyst/sentry::users.login_attribute');

                $validator = Validator::make(Input::all(),array(
                    $loginAttribute => 'required',
                    'password' => 'required'
                ));

                if($validator->fails())
                {
                    return Redirect::back()->withErrors($validator);
                }


                $credentials = array(
                    $loginAttribute => Input::get($loginAttribute),
                    'password' => Input::get('password'),
                );

                Sentry::authenticate($credentials, (bool)Input::get('remember'));

                return Redirect::route('homeGet');

            } catch(\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                return Redirect::back()->withErrors([trans('syntara::all.messages.banned')]);
            } catch (\RuntimeException $e) {
                return Redirect::back()->withErrors([trans('syntara::all.messages.login-failed')]);
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
                    'username' => 'required|min:3|max:255|alpha_dash|unique:users,username,'.$user->id,
                    'email' => 'required|email|unique:users,email,'.$user->id,
                );

                if (Input::get('password')) {
                    $rules['password'] = 'required|min:6|max:255|confirmed';
                }

                $validator = Validator::make(Input::all(),$rules);

                if ($validator->fails()) {

                    return Redirect::back()->withInput()->withErrors($validator);

                }

                $user->email = Input::get('email');
                $user->username = Input::get('username');
                $user->first_name = (string)Input::get('first_name');
                $user->last_name = (string)Input::get('last_name');
                if (Input::get('password')) {
                    $user->password = Input::get('password');
                }
                $user->save();

                return Redirect::back()->with('success',trans('user.edit-profile.success'));

            } catch (Exception $e) {
                return Redirect::back()->withErrors([$e->getMessage()]);
            }

        }

    }