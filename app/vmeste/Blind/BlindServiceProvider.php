<?php

namespace Vmeste\Blind;
use Illuminate\Support\ServiceProvider;

class BlindServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['blind'] = $this->app->share(function($app)
        {
            return new Blind($app['view']);
        });

        \Route::filter('VmesteBlindFilter', function()
        {
            global $app;
            $isEnabled = $app['blind']->isEnabled();

            $params = explode('/', \Request::path());
            if (count($params) > 0)
            {
                $prefixCode = $params[0];
                $prefix = $app['blind']->getPrefix();
                $redirection = false;

                if ($prefixCode === $prefix) {

                    if (!$isEnabled) {

                        $app['blind']->setRoutePrefix($prefix);

                    }

                } else {

                    if ($isEnabled) {

                        $app['blind']->setRoutePrefix('off_blind_mode');

                    }

                }

                if($redirection)
                {
                    // Save any flashed data for redirect
                    \Session::reflash();
                    return \Redirect::to($redirection, 307)->header('Vary','Accept-Language');
                }
            }
        });

    }
}
