<?php

namespace App\Foundation;

use Illuminate\Filesystem\Filesystem;

/**
 * Extends the PackageManifest.
 * This class correctly handles a non-default vendor-dir config setting in the composer.json file.
 *
 * @package App\Foundation
 */
class PackageManifest extends \Illuminate\Foundation\PackageManifest
{

    public function __construct(Filesystem $files, string $basePath, string $manifestPath)
    {
        parent::__construct($files, $basePath, $manifestPath);

        $this->vendorPath = $basePath . '/' . $this->getConfigVendorDir();
    }

    protected function getConfigVendorDir()
    {
        return json_decode(file_get_contents(
                $this->basePath . '/composer.json'
            ), true)['config']['vendor-dir'] ?? 'vendor';
    }
}