<?php
/** @var rex_addon $redaxoAddOn */
/** @var string $uri */

/** @var App\Http\Kernel $kernel */
list($kernel, $terminate) = require __DIR__ . '/kernel.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$request = App\Http\FrontendRequest::capture();
$request->uri = $uri;

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$returnValue = null;
if ($response instanceof \Illuminate\Http\RedirectResponse) {
    $response->send();
} else if ($response instanceof \Illuminate\Http\JsonResponse) {
    $returnValue = $response->getOriginalContent();
} else {
    $response->sendHeaders();
    $response->sendContent();
}

$terminate($request, $response);

return $returnValue;
