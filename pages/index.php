<?php
/** @var rex_addon $this */
$redaxoAddOn = $this;

$redaxoRestoreFunc = require __DIR__ . '/redaxo_cleanup.php';

/** @var App\Http\Kernel $kernel */
$kernel = require __DIR__ . '/kernel.php';

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

if ($response instanceof \Illuminate\Http\RedirectResponse) {
    $response->send();
} else {
    $response->sendHeaders();
    $response->sendContent();
}

$kernel->terminate($request, $response);

$redaxoRestoreFunc();
