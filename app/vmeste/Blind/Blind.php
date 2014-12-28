<?php

namespace Vmeste\Blind;
use \Illuminate\View\Factory;

class Blind {

    protected $prefix;
    protected $enabled = false;
    protected $cookieName;
    protected $view;

    public function __construct(Factory $view) {

        $config = \Config::get('blind');
        $this->prefix = $config['prefix'];
        $this->cookieName = $config['cookieName'];
        $this->view = $view;
        $this->checkEnabled();

    }

    public function setRoutePrefix($prefix = null) {

        if (is_null($prefix) || !is_string($prefix))
        {
            $prefix = \Request::segment(1);
        }

        if ($prefix === $this->prefix)
        {
            $this->enabled = true;
        }
        else
        {

            $prefix = null;
            $this->enabled = false;

        }

        \Cookie::queue(\Cookie::forever($this->cookieName, $this->enabled));

        return $prefix;

    }

    public function getBlindSwitcher() {

        $url = '';
        $path = \Request::path();

        if ($this->isEnabled()) {

            if (strpos($path, $this->prefix) !== false) {

                $url = trim(str_replace($this->prefix,null,$path),'/');

            }

        } else {

            if (strpos($path, $this->prefix) === false) {

                $url = $this->prefix . '/' . $path;

            }

        }

        $view = 'blind-switcher';

        return $this->view->make($view, array(
            'enabled' => $this->isEnabled(),
            'url' => $url,
        ));

    }

    public function isEnabled() {

        return (bool) $this->enabled;

    }

    public function getPrefix() {

        return (string) $this->prefix;

    }

    protected function checkEnabled() {

        $this->enabled = (bool) \Cookie::get($this->cookieName, false);

    }

}
