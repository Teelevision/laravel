<?php
/** @var rex_addon $redaxoAddOn */

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

if (!defined('LARAVEL_START')) {
    define('LARAVEL_START', microtime(true));
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

/**
 * Why use "vendor-composer" instead of the default "vendor"?
 * REDAXO will try to analyse and cache information about all php files
 * stored in the "lib" and "vendor" directories of an add-on. We are
 * loading the whole Laravel framework which are a lot of files to analyse.
 * This takes way too long and isn't necessary. Renaming the directory
 * makes REDAXO got unnoticed of all those files.
 */
require_once __DIR__ . '/../vendor-composer/autoload.php';

/*
|--------------------------------------------------------------------------
| Correct Global State
|--------------------------------------------------------------------------
|
| Redaxo might use global settings that we have to reset.
| We restore those settings later.
|
*/

$redaxoState = [
    'arg_separator.output' => ini_get('arg_separator.output'),
];

ini_set('arg_separator.output', '&');

$restoreRedaxoState = function () use ($redaxoState) {
    ini_set('arg_separator.output', $redaxoState['arg_separator.output']);
};

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

/** @var \App\Foundation\Application $app */
$app = require __DIR__ . '/../bootstrap/app.php';
$app->setRedaxoAddOn($redaxoAddOn);

/*
|--------------------------------------------------------------------------
| Prepare Request And Termination
|--------------------------------------------------------------------------
|
| Prepare the kernel that handles requests.
| Also prepare the termination, i.e. what happens after handling the
| request.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$terminate = function ($request, $response) use ($kernel, $restoreRedaxoState) {
    $kernel->terminate($request, $response);
    $restoreRedaxoState();
};

return [$kernel, $terminate];
