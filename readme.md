# Laravel as Redaxo5 add-on

`teelevision/redaxo5-laravel` is a port of the [Laravel framework](https://github.com/laravel/laravel) that runs as an add-on in [Redaxo5](https://github.com/redaxo/redaxo). It aims at enabling you to write Redaxo5 add-ons the way you would write a Laravel application. 

## Documentation

This documentation only covers the differences to the [Laravel documentation](https://laravel.com/docs/5.6). Any topic not mentioned below should in theory work as described in the Laravel documentation. In practice many features are yet untested.

### [Installation](https://laravel.com/docs/5.6/installation)

In addition to the [Server Requirements](https://laravel.com/docs/5.6/installation#server-requirements) you will need a running instance of Redaxo version 5.0 or greater.

Inside your Redaxo installation go to `/redaxo/src/addons` and run the following to install:
```bash
composer create-project teelevision/redaxo5-laravel my_laravel_addon "5.6.*"
```

You do not need to configure your web server. I mean, there is no way to, you have to get a web server running Redaxo, not the add-on. You can use pretty URLs in the frontend using [YRewrite](https://github.com/yakamara/redaxo_yrewrite), I suppose. In the backend pretty URLs are not be supported.

You should still [configure](https://laravel.com/docs/5.6/installation#configuration) your `.env` file, especially creating an application key.

Like every other add-on you have to install it in the Redaxo backend in order to use it.

Make sure that the root directory of your add-on is writable, as well as the `storage` directory, its sub-directories, and the `bootstrap/cache` directory.

### [Directory Structure](https://laravel.com/docs/5.6/structure) and [Request Lifecycle](https://laravel.com/docs/5.6/lifecycle)

* The `assets` directory is the [Redaxo add-on `assets` directory](https://redaxo.org/doku/master/addon-assets). Any files placed here are copied to a public directory when installing the add-on.
* [The `config` directory](https://laravel.com/docs/5.6/structure#the-config-directory) does not contain the `cache` directory which instead is moved to Redaxo's cache.
* The `lib` directory is used by add-ons to provide code that Redaxo scans and auto-loads. So this is directory needs to be used for classes and functions that should be available in the frontend (Redaxo modules) or to other add-ons.
* The `pages` directory
  * Contains some files for booting laravel in the backend and frontend.
  * The entry point for all requests to the add-on are the files `pages/index.php` and `pages/frontend.php` instead of `public/index.php`. But those files do not really qualify as entry points. They are more like the interface between the add-on and Redaxo or other add-ons. Redaxo calls `pages/index.php` automatically for any backend add-on page.
* [The `public` directory](https://laravel.com/docs/5.6/structure#the-public-directory) does not exist. The functionality lies within the `assets` and `pages` directories.
* [The `storage` directory](https://laravel.com/docs/5.6/structure#the-storage-directory)
  * The compiled Blade templates and the framework cache are stored in Redaxo's cache rather than this directory.
* [The `vendor` directory](https://laravel.com/docs/5.6/structure#the-vendor-directory) is renamed `vendor-composer` because otherwise Redaxo tries to index all the files in there which could take minutes.
* The `package.yml` file describes your add-on and is required by Redaxo.
* The `app/Redaxo` directory contains models for redaxo database tables like users. This does not yet contain all models and each model could be incomplete.

### [Routing](https://laravel.com/docs/5.6/routing)

* A route's uri is matched against the `page` query parameter instead of the path of the uri. For example the route `my_laravel_addon/welcome` matches `page=my_laravel_addon/welcome` which is how Redaxo knows where to route a request in the backend. This requires you to begin your route's uri with the name of your add-on. However you can define frontend routes that do not have this limitation. Frontend routes can be called using `MyLaravelAddOn::frontend('route_uri')` from Redaxo modules in the frontend or basically from everywhere outside your add-on.
* You have to describe all your routes in your `package.yml` so that Redaxo knows that it should call your add-on.
* Route parameters are not supported since all routes have to be pre-defined in the `package.yml` which does not support it. The query parameters except `page` are used as route parameters instead for callback/controller arguments. This is untested if there are multiple parameters since the order might not be defined which would lead to problems. So only use one parameter to be sure. Also there is no equivalent for a required parameter, which requires you to check each argument yourself. It could be possible to write a route validator using the route's wheres to achieve this.

### [HTTP Responses](https://laravel.com/docs/5.6/responses)

* When returning a JSON response on a *frontend* route the content of the response is returned to the caller of `MyLaravelAddOn::frontend($uri)`. Otherwise `null` is returned.

### [Views](https://laravel.com/docs/5.6/views)

* Redaxo embeds the output of your add-on in the HTML that Redaxo generates in the backend and frontend. Therefore your views don't need to generate HTML headers and the sort.

### [URL Generation](https://laravel.com/docs/5.6/urls)

* You can generate urls using `action()` and `route()` helpers for backend routes only. This is because for frontend routes it is not generally possible to tell from which single url a frontend route will be called. Frontend routes can be called from anywhere outside your add-on.
* Don't use the `url()` helper to generate urls, instead use the [`rex_url` class](https://redaxo.org/doku/master/pfade) and [`rex_getUrl` function](https://redaxo.org/doku/master/service-urls) provided by Redaxo.

### [Pagination](https://laravel.com/docs/5.6/pagination)

* Per default any pagination uses the `page` query parameter which is used by Redaxo in the backend for routing requests. Therefore you have to explicitly change the pagination page parameter like for example: `->paginate(15, ['*'], 'p')`.

## Motivation

Redaxo provides very little for add-ons compared to the huge frameworks like Laravel. While this works for small add-ons it hardly satisfies my developer needs when creating something bigger. During one project I saw myself using more and more of the [`illuminate/*` packages](https://github.com/illuminate) that I love so much, that I decided to try booting the whole framework. I don't want to take a stand on whether this is a good idea, I just want to share this solution that helped me finish that one project.

## License

The Laravel framework is licensed as stated on [their page](https://github.com/laravel/laravel).

All changes to the Laravel framework in this repository are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
