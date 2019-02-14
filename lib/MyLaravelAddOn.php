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

    /**
     * @var array
     */
    protected static $params = [];


    public static function frontend(string $uri, array $params = [])
    {
        static::$params = $params;
        $frontend = require __DIR__ . '/../pages/frontend.php';
        return $frontend(static::$redaxoAddOn, $uri);
    }

    public function getParams(): array
    {
        return self::$params;
    }
}