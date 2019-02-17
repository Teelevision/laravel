<?php

namespace App\Routing;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{

    /**
     * Get the URL for a given route instance.
     *
     * @param  Route $route
     * @param  mixed $parameters
     * @param  bool $absolute
     * @return string
     *
     * @throws \Illuminate\Routing\Exceptions\UrlGenerationException
     */
    protected function toRoute($route, $parameters, $absolute)
    {
        $route = clone $route;

        /**
         * Set the uri as the page parameter.
         */
        $parameters['page'] = $route->uri();

        if (\rex::isBackend()) {
            /**
             * Generating the backend url from the backend: no uri needed.
             */
            $route->setUri('');
        } else {
            /**
             * Generating the backend url from the frontend: set the uri to redaxo's backend controller.
             */
            $route->setUri(\rex_url::backendController());
        }

        $uri = parent::toRoute($route, $parameters, $absolute);

        return $this->fixSlashBeforeQuery($uri);
    }


    /**
     * Fix missing "/" before the query part of an uri,
     * unless it's already there or a php script is called directly.
     *
     * @param string $uri
     * @return string
     */
    protected function fixSlashBeforeQuery(string $uri): string
    {
        if (str_contains($uri, '?') && !str_contains($uri, ['/?', '.php?'])) {
            return str_replace_first('?', '/?', $uri);
        }
        return $uri;
    }
}