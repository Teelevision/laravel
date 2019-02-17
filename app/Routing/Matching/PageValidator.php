<?php

namespace App\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;
use App\Http\FrontendRequest;

/**
 * Validates that either the request is a frontend request that provides the page parameter,
 * or the page parameter is in the query parameters.
 * The page parameter is then matched against the uri of the route.
 *
 * For example in the backend "/index.php?page=addon/foo/bar"
 * should be matched like the uri validator would match "/addon/foo/bar".
 *
 * In case of the frontend request, the page parameter is injected. However if a action query parameter
 * is given, it replaces the action of the page.
 * For example with the given page "some_page/output" and "action=index"
 * the page will result in "some_page/index".
 *
 * @package App\Routing\Matching
 */
class PageValidator implements ValidatorInterface
{

    public function matches(Route $route, Request $request)
    {
        if ($request instanceof FrontendRequest) {
            $page = $request->uri;
            $action = $request->query->get('action', '');
            if ($action !== '') {
                $page = implode('/', array_slice(explode('/', $page), 0, -1)) . '/' . $action;
            }
        } else {
            $page = $request->query->get('page', '');
        }

        $path = '/' . $page;

        return preg_match($route->getCompiled()->getRegex(), rawurldecode($path));
    }
}