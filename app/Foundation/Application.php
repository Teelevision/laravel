<?php

namespace App\Foundation;

use App\Http\FrontendRequest;
use App\Routing\RoutingServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Foundation\PackageManifest as BasePackageManifest;
use Illuminate\Log\LogServiceProvider;

class Application extends \Illuminate\Foundation\Application
{

    /**
     * @var \rex_addon|null
     */
    protected $redaxoAddOn;

    /**
     * @var string|null
     */
    protected $redaxoPath;

    /**
     * @var string|null
     */
    protected $redaxoBackendPath;

    /**
     * @var string|null
     */
    protected $redaxoAddOnName;

    /**
     * @var
     */
    protected $redaxoConfig;


    /**
     * @return \rex_addon|null
     */
    public function getRedaxoAddOn()
    {
        return $this->redaxoAddOn;
    }

    /**
     * @param \rex_addon|null $redaxoAddOn
     */
    public function setRedaxoAddOn($redaxoAddOn)
    {
        $this->instance('redaxo.addon', $this->redaxoAddOn = $redaxoAddOn);
    }

    public function setBasePath($basePath)
    {
        $this->redaxoPath = dirname($basePath, 4);
        $this->redaxoBackendPath = dirname($basePath, 3);
        $this->instance('redaxo.addon.name', $this->redaxoAddOnName = basename($basePath));

        return parent::setBasePath($basePath);
    }

    public function redaxoPath($path = ''): string
    {
        return $this->redaxoPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function redaxoBackendPath($path = ''): string
    {
        return $this->redaxoBackendPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function redaxoAddOnAssetsPath(): string
    {
        return $this->redaxoPath('assets/addons/' . $this->redaxoAddOnName);
    }

    public function redaxoAddOnDataPath(): string
    {
        return $this->redaxoBackendPath('data/addons/' . $this->redaxoAddOnName);
    }

    public function redaxoAddOnCachePath(): string
    {
        return $this->redaxoBackendPath('cache/addons/' . $this->redaxoAddOnName);
    }

    protected function registerBaseBindings()
    {
        parent::registerBaseBindings();

        $this->rebindPackageManifest();
    }

    protected function rebindPackageManifest()
    {
        $base = $this->make(BasePackageManifest::class);

        $this->instance(BasePackageManifest::class, new PackageManifest(
            $base->files, $base->basePath, $base->manifestPath
        ));
    }

    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));

        $this->register(new LogServiceProvider($this));

        $this->register(new RoutingServiceProvider($this));
    }

    public function registerCoreContainerAliases()
    {
        parent::registerCoreContainerAliases();

        foreach ([
                     'redaxo.addon' => [\rex_addon::class],
                     'url' => [\App\Routing\UrlGenerator::class],
                     'request' => [FrontendRequest::class],
                 ] as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();

        $this->instance('path.redaxo', $this->redaxoPath());
        $this->instance('path.redaxo.backend', $this->redaxoBackendPath());
        $this->instance('path.redaxo.addon.assets', $this->redaxoAddOnAssetsPath());
        $this->instance('path.redaxo.addon.data', $this->redaxoAddOnDataPath());
        $this->instance('path.redaxo.addon.cache', $this->redaxoAddOnCachePath());
    }
}