<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| In the backend Redaxo uses the page parameter of the uri to route
| requests. Therefore in order for a request to reach this add-on the
| value has to start with this add-on's name. Once the request reaches this
| add-on we do the route matching on the whole page parameter of the uri.
| That is why your backend routes should start with this add-on's name.
| You can still define other routes that you call explicitly, for example
| from a Redaxo module.
|
*/

Route::get('my_laravel_addon/welcome', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Frontend (Redaxo Module) Route
|--------------------------------------------------------------------------
|
| This is an example of an frontend route that you can use in a Redaxo
| module. This module could look like this:
|
| Input:
|   <input type="text" name="REX_INPUT_VALUE[1]" value="REX_VALUE[1]">
|
| Output:
|   <?php MyLaravelAddOn::headline('REX_VALUE[1]', 1);
|
*/

Route::get('headline', function (\App\Http\FrontendRequest $request) {
    $text = e($request->data['text']);
    $level = $request->data['level'];
    return "<h$level>$text</h$level>";
});
