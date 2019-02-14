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

/**
 * Let the facade know about the rex_addon instance.
 */
MyLaravelAddOn::$redaxoAddOn = $this;
