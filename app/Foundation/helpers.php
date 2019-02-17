<?php

if (!function_exists('redaxo_path')) {
    function redaxo_path(string $path = ''): string
    {
        return app('path.redaxo') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('redaxo_backend_path')) {
    function redaxo_backend_path(string $path = ''): string
    {
        return app('path.redaxo.backend') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('redaxo_addon_assets_path')) {
    function redaxo_addon_assets_path(string $path = ''): string
    {
        return app('path.redaxo.addon.assets') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('redaxo_addon_data_path')) {
    function redaxo_addon_data_path(string $path = ''): string
    {
        return app('path.redaxo.addon.data') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('redaxo_addon_cache_path')) {
    function redaxo_addon_cache_path(string $path = ''): string
    {
        return app('path.redaxo.addon.cache') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('redaxo_config')) {
    /**
     * Get the specified redaxo configuration value.
     *
     * @param  string|null $key
     * @param  mixed $default
     * @return mixed|\Illuminate\Config\Repository
     */
    function redaxo_config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('redaxo.config');
        }

        return app('redaxo.config')->get($key, $default);
    }
}

if (!function_exists('redaxo_packages')) {
    /**
     * Get the specified redaxo package configuration value.
     *
     * @param  string|null $key
     * @param  mixed $default
     * @return mixed|\Illuminate\Config\Repository
     */
    function redaxo_packages($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('redaxo.packages');
        }

        return app('redaxo.packages')->get($key, $default);
    }
}

if (!function_exists('page_field')) {
    /**
     * Creates a hidden input tag that sets the page query parameter to the given page.
     * If no page is given, the current page is used.
     *
     * @param string|null $page
     * @return \Illuminate\Support\HtmlString
     */
    function page_field(string $page = null)
    {
        $route = is_null($page)
            ? app('router')->getCurrentRoute()
            : app('router')->getRoutes()->getByName($page);

        if (is_null($route)) {
            throw new \InvalidArgumentException("Page [$page] not found.");
        }

        return new \Illuminate\Support\HtmlString(
            '<input type="hidden" name="page" value="' . $route->uri() . '">'
        );
    }
}

if (!function_exists('redaxo_temp_filepath')) {
    /**
     * Returns a temporary file path.
     *
     * @return string
     */
    function redaxo_temp_filepath(): string
    {
        return tempnam(sys_get_temp_dir(), 'redaxo_' . app('redaxo.addon.name'));
    }
}

if (!function_exists('redaxo_addon_permission_name')) {
    /**
     * Generates the redaxo permission name for your addon.
     *
     * Permission in redaxo have the form "your_addon[permission]".
     * The general permission "your_addon[]" is required to access the addon.
     *
     * @param string $permission
     * @return string
     */
    function redaxo_addon_permission_name(string $permission = ''): string
    {
        return app('redaxo.addon.name') . '[' . $permission . ']';
    }
}

if (!function_exists('redaxo_addon')) {
    function redaxo_addon(): \rex_addon
    {
        return app('redaxo.addon');
    }
}
