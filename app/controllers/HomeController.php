<?php

    class HomeController extends BaseController
    {

        public function getIndex()
        {

            $this->layout = View::make('app.home.index');
            $this->layout->title = 'Главная';

        }

    }