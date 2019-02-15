<?php
/** @var rex_addon $this */

/**
 * register permissions
 */
if (rex::isBackend() && is_object(rex::getUser())) {
    rex_perm::register($this->getName() . '[]', 'Use My Laravel AddOn');
}

/**
 * load scripts and styles
 */
if (rex::isBackend()) {
    try {
        rex_view::addCssFile($this->getAssetsUrl('css/backend.css'));
        rex_view::addJsFile($this->getAssetsUrl('js/backend.js'));
    } catch (rex_exception $e) {
        // well, then ...
    }
}

/*
|--------------------------------------------------------------------------
| Enable Frontend Requests
|--------------------------------------------------------------------------
|
| MyLaravelAddOn is the facade between this add-on and other parts of
| Redaxo. In order to handle requests from other add-ons or modules it must
| know about the Redaxo add-on instance.
|
*/
MyLaravelAddOn::setRedaxoAddOn($this);
