<?php

/**
 * This class is the facade for Redaxo modules and other add-ons to use my laravel add-on.
 */
abstract class MyLaravelAddOn
{

    /**
     * @var rex_addon
     */
    protected static $redaxoAddOn;


    public static function setRedaxoAddOn(rex_addon $redaxoAddOn)
    {
        static::$redaxoAddOn = $redaxoAddOn;
    }

    public static function frontend(string $uri, array $data = [])
    {
        return self::handle($uri, $data, static::$redaxoAddOn);
    }

    protected static function handle(string $uri, array $data, rex_addon $redaxoAddOn)
    {
        /**
         * If you are editing a Redaxo article slice Redaxo will save all values
         * and call the used module output code during the same request.
         * The output is important for displaying the changes in the user interface.
         * This means that this method can be called during such a POST request,
         * in which case we do a redirect to a GET request. Redaxo will find the
         * updated module output of the article slice to display in the user interface
         * and we are not bothered with wrong POST requests.
         * All other POST requests are handled as intended by the route configuration.
         */
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['page'] === 'content/edit' && rex::isBackend()) {
            $uri = str_replace('&function=edit', '', $_SERVER['HTTP_REFERER']);
            header('Location: ' . $uri, true, 302);
            exit;
        }

        return require __DIR__ . '/../pages/frontend.php';
    }

    public static function headline(string $text, int $level = 1)
    {
        return self::frontend('headline', compact('text', 'level'));
    }
}