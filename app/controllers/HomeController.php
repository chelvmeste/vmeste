<?php

    class HomeController extends BaseController
    {

        public function getIndex()
        {

            Assets::addJs(array(
                '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                'map.index.js'
            ));


            $this->layout = View::make('app.home.index');
//            $this->layout->title = trans('home.index.title');

        }

    }