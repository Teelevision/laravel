<?php

/**
 * This class is the facade for Redaxo modules and other add-ons to use my laravel add-on.
 */
abstract class MyLaravelAddOn
{

    /**
     * @var rex_addon
     */
    public static $redaxoAddOn;


    public static function frontend(string $uri)
    {
        return self::handle($uri, static::$redaxoAddOn);
    }

    protected static function handle(string $uri, rex_addon $redaxoAddOn)
    {
        return require __DIR__ . '/../pages/frontend.php';
    }
}