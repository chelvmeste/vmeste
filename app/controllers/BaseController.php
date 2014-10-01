<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
        $this->layout = View::make('layouts.app.layout');
        $this->layout->title = 'Вместе';

        Assets::addCss(array(
            'bootstrap.css',
            'main.css',
        ));

        Assets::addJs(array(
            'jquery-1.11.1.js',
            'bootstrap.js',
        ));

	}

}
