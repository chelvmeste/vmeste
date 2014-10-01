<?php

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

    }