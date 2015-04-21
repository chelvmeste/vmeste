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
                'bootstrap.css',
                'nprogress.css',
                'main.css',
            ));
            Assets::addJs(array(
                'jquery-1.11.1.js',
                'bootstrap.js',
                'nprogress.js',
                'global.js',
            ));
        }
        else
        {
            Assets::addCss(array(
                'bootstrap.css',
                'style.css',
                'datepickerUI.css',
                'fonts/fonts.css',
            ));
            Assets::addJs(array(
                'jquery-1.11.1.js',
                'bootstrap.js',
                'nprogress.js',
                'selectbox.js',
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
