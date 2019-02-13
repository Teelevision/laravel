# Laravel as Redaxo5 add-on

`teelevision/redaxo5-laravel` is a port of the [Laravel framework](https://github.com/laravel/laravel) that runs as an add-on in [Redaxo5](https://github.com/redaxo/redaxo). It aims at enabling you to write Redaxo5 add-ons the way you would write a Laravel application. 

## Documentation

This documentation only covers the differences to the [Laravel documentation](https://laravel.com/docs/5.5). Any topic not mentioned below is untested and might not be ready to use.

### Getting Started

#### [Installation](https://laravel.com/docs/5.5/installation)

In addition to the [Server Requirements](https://laravel.com/docs/5.5/installation#server-requirements) you will need a running instance of Redaxo version 5.0 or greater.

Inside your Redaxo installation go to `/redaxo/src/addons` and run the following to install:
```bash
composer create-project teelevision/redaxo5-laravel my_laravel_addon "5.5.*"
```

You do not need to configure your web server. I mean, there is no way to, you have to get a web server running Redaxo, not the add-on. You can use pretty URLs in the frontend using [YRewrite](https://github.com/yakamara/redaxo_yrewrite), I suppose. In the backend pretty URLs are not be supported.

You should still [configure](https://laravel.com/docs/5.5/installation#configuration) your `.env` file, especially creating an application key.

Like every other add-on you have to install it in the Redaxo backend in order to use it.

Make sure that the root directory of your add-on is writable, as well as the `storage` directory, its sub-directories, and the `bootstrap/cache` directory.

#### [Configuration](https://laravel.com/docs/5.5/configuration)

* [Environment Configuration](https://laravel.com/docs/5.5/configuration#environment-configuration)
* [Accessing Configuration Values](https://laravel.com/docs/5.5/configuration#accessing-configuration-values)

#### [Directory Structure](https://laravel.com/docs/5.5/structure)

* [Introduction](https://laravel.com/docs/5.5/structure#introduction)
* The Root Directory
  * [The `app` Directory](https://laravel.com/docs/5.5/structure#the-root-app-directory)
  * The `assets` Directory
    * This is the [Redaxo add-on `assets` directory](https://redaxo.org/doku/master/addon-assets). Any files placed here are copied to a public directory when installing the add-on.
  * [The `bootstrap` Directory](https://laravel.com/docs/5.5/structure#the-bootstrap-directory)
  * [The `config` Directory](https://laravel.com/docs/5.5/structure#the-config-directory)
    * Does not contain the `cache` directory which instead is moved to Redaxo's cache.
  * [The `database` Directory](https://laravel.com/docs/5.5/structure#the-database-directory)
  * The `lib` Directory
    * The `lib` directory is used by add-ons to provide code that Redaxo scans and auto-loads. So this is directory needs to be used for classes and functions that should be available in the frontend (Redaxo modules) or to other add-ons.
  * The `pages` Directory
    * Contains some files for booting laravel in the backend and frontend.
    * In the backend Redaxo calls the `index.php`
  * [The `public` Directory](https://laravel.com/docs/5.5/structure#the-public-directory)
    * Does not exist. The functionality lies within the `assets` and `pages` directories.
  * [The `resources` Directory](https://laravel.com/docs/5.5/structure#the-resources-directory)
  * [The `routes` Directory](https://laravel.com/docs/5.5/structure#the-routes-directory)
  * [The `storage` Directory](https://laravel.com/docs/5.5/structure#the-storage-directory)
    * As documented, except the compiled Blade templates and the framework cache are stored in Redaxo's cache rather than this directory.
  * [The `tests` Directory](https://laravel.com/docs/5.5/structure#the-tests-directory)
  * [The `vendor` Directory](https://laravel.com/docs/5.5/structure#the-vendor-directory)
    * Is renamed `vendor-composer` because otherwise Redaxo tries to index all the files in there which could take minutes.
  * The `vendor-composer` Directory
    * Does what the [`vendor` directory](https://laravel.com/docs/5.5/structure#the-vendor-directory) does in Laravel.
* [The App Directory](https://laravel.com/docs/5.5/structure#the-app-directory)

## Motivation

Redaxo provides very little for add-ons compared to the huge frameworks like Laravel. While this works for small add-ons it hardly satisfies my developer needs when creating something bigger. During one project I saw myself using more and more of the [`illuminate/*` packages](https://github.com/illuminate) that I love so much, that I decided to try booting the whole framework. I don't want to take a stand on whether this is a good idea, I just want to share this solution that helped me finish that one project.

## License

The Laravel framework is licensed as stated on [their page](https://github.com/laravel/laravel).

All changes to the Laravel framework in this repository are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
