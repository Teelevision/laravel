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


    public static function frontend(string $uri, array $data = [])
    {
        return self::handle($uri, $data, static::$redaxoAddOn);
    }

    protected static function handle(string $uri, array $data, rex_addon $redaxoAddOn)
    {
        return require __DIR__ . '/../pages/frontend.php';
    }

    public static function headline(string $text, int $level = 1)
    {
        return self::frontend('headline', compact('text', 'level'));
    }
}