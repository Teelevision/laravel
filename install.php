<?php
/** @var rex_addon $this */

require_once __DIR__ . '/vendor-composer/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

/**
 * Create cache directories
 */
foreach ([
             redaxo_addon_cache_path('data'),
             redaxo_addon_cache_path('views'),
             redaxo_addon_data_path(),
             redaxo_addon_assets_path(),
         ] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}
