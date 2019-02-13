<?php
/** @var rex_addon $redaxoAddOn */

/**
 * Save redaxo state. To be restored later.
 */
$state = [
    'arg_separator.output' => ini_get('arg_separator.output'),
];

/**
 * Restore sanity.
 */
ini_set('arg_separator.output', '&');

return function () use ($state) {
    /**
     * Restore redaxo state.
     */
    ini_set('arg_separator.output', $state['arg_separator.output']);
};
