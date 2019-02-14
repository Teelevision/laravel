<?php /** @noinspection PhpUnusedParameterInspection */

/**
 * Executes the action and returns the result if it yields a json response.
 * Otherwise the response is send to the browser and null is returned.
 *
 * The $uri argument must be the uri of a route. See ../routes/web.php.
 * The last part of the uri is the action which is overwritten by the "action" query parameter.
 * For example if you provide "users/index" as $uri, the route "users/index" is matched.
 * But if the query additionally contains "action=edit", the route "users/edit" is matched.
 * This enables you to have multiple actions in the frontend while using a single module.
 * The action that you provide via $uri is the default action in case that no "action" query parameter is given.
 * You must always provide the default action.
 *
 * You can generate routes using for example route('users/edit'). This will return the current route with the query
 * parameter "action=edit".
 *
 * @param rex_addon $redaxoAddOn
 * @param string $uri
 * @return mixed
 */
return function (rex_addon $redaxoAddOn, string $uri) {

    $redaxoRestoreFunc = require __DIR__ . '/redaxo_cleanup.php';

    /** @var App\Http\Kernel $kernel */
    $kernel = require __DIR__ . '/kernel.php';

    $request = App\Http\FrontendRequest::capture();
    $request->page = 'frontend/' . $uri;

    $response = $kernel->handle($request);

    $returnValue = null;
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        $response->send();
    } else if ($response instanceof \Illuminate\Http\JsonResponse) {
        $returnValue = $response->getOriginalContent();
    } else {
        $response->sendHeaders();
        $response->sendContent();
    }

    $kernel->terminate($request, $response);

    $redaxoRestoreFunc();

    return $returnValue;
};
