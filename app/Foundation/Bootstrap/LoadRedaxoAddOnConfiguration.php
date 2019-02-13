<?php

namespace App\Foundation\Bootstrap;

use Illuminate\Config\Repository;
use App\Foundation\Application;

class LoadRedaxoAddOnConfiguration
{

    /**
     * Bootstrap the given application.
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $path = redaxo_backend_path('cache/core/packages.cache');

        $content = file_get_contents($path);

        $config = json_decode($content, true);

        $app->instance('redaxo.packages', new Repository($config));
    }
}