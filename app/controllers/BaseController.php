<?php

class BaseController extends Controller {

    protected $scriptComposer = array();

    protected $currentUser = null;

    protected $bodyClasses = ['page-start'];

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
        $this->currentUser = Sentry::getUser();

        $this->layout = Blind::isEnabled() ? View::make('layouts.app.layout_blind') : View::make('layouts.app.layout');
        $this->layout->title = 'Вместе';

        $this->scriptComposer['geoConfig'] = json_encode(Config::get('geo'));

        if (Blind::isEnabled())
        {
            Assets::addCss(array(
                'blind.css',
            ));
            Assets::addJs(array(
                'vendor.js',
                'global.js',
            ));
        }
        else
        {
            Assets::addCss(array(
                'app.css',
            ));
            Assets::addJs(array(
                'vendor.js',
                'global.js',
            ));
        }

        View::composer('script-composer', function($view) {
            $view->with('scriptComposer', $this->scriptComposer);
        });
        View::share('currentUser', $this->currentUser);
        View::share('bodyClasses', $this->bodyClasses);

//        Statistics::logUniqueEvent('siteVisit');
//        Statistics::logEvent('pageView');
//        Event::fire('vmeste.createResponse');

	}

}
