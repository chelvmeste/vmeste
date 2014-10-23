<?php

class OfferController extends BaseController {

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

        $this->layout = View::make('app.offer.help-request',array(
            'user' => $user,
        ));
        $this->layout->title = trans('offer.help-request.title');
    }

    public function getHelpOffer()
    {

    }

}