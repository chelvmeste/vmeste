<?php

//use MrJuliuss\Syntara\Services\Validators\User as UserValidator;

    class UserController extends BaseController
    {

        public function getRegister()
        {

            $this->layout = View::make('app.user.register');
            $this->layout->title = trans('user.register.title');

            Assets::addJs('register.js');

        }

        public function getLogin()
        {

            $this->layout = View::make('app.user.login');
            $this->layout->title = trans('user.login.title');

            Assets::addJs('login.js');

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

            } catch(\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                return Redirect::back()->withErrors([trans('syntara::all.messages.banned')]);
            } catch (\RuntimeException $e) {
                return Redirect::back()->withErrors([trans('syntara::all.messages.login-failed')]);
            }

            Redirect::route('homeGet');

        }

        public function getLogout()
        {

            Sentry::logout();

            Redirect::route('homeGet');

        }

    }