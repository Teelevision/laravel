<?php

namespace App\Routing;

class Router extends \Illuminate\Routing\Router
{

    protected function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }
}