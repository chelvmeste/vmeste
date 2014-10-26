<?php

    class MapController extends BaseController {

        public function getIndex()
        {

            Assets::addJs(array(
                '//api-maps.yandex.ru/2.1/?lang=ru_RU',
                'map.index.js'
            ));



            $this->layout = View::make('app.map.index');
            $this->layout->title = trans('map.index.title');

        }

    }