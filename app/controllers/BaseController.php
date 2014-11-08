<?php

class BaseController extends Controller {

    protected $scriptComposer = array();

    protected $currentUser = null;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
        $this->currentUser = Sentry::getUser();

        $this->layout = View::make('layouts.app.layout');
        $this->layout->title = 'Вместе';

        $this->scriptComposer['geoConfig'] = json_encode(Config::get('geo'));

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

        View::composer('script-composer', function($view) {
            $view->with('scriptComposer', $this->scriptComposer);
        });
        View::share('currentUser',$this->currentUser);

	}

}
