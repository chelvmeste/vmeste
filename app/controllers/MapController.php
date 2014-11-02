<?php

    class MapController extends BaseController
    {

        public function getIndex()
        {

            Assets::addJs(array(
                '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                'map.js',
                'map.index.js'
            ));


            $this->layout = View::make('app.home.index');
            $this->layout->title = trans('map.title');

        }

        /**
         * Ajax action to get ap settings
         * @return \Illuminate\Http\JsonResponse
         */
        public function getMapSettings()
        {
            return Response::json(Config::get('geo'));
        }

    }