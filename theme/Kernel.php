<?php

namespace NormanHuth\WpChild;

class Kernel
{
    public static ?string $themeSlug;
    public static string $themePath;
    public static string $autoloadedPath;
    public static array $manifest;
    public static string $themeUrl;
    public static string $themeVersion;
    public static array $config;

    /**
     * @param string|null $key
     * @return array|string|null
     */
    public static function getConfig(?string $key = null)
    {
        if (empty(static::$config)) {
            static::$config = require static::getThemePath('config/theme.php');
        }

        if ($key) {
            return static::$config[$key];
        }

        return static::$config;
    }

    /**
     * Enqueue CSS-Stylesheet Files From `assets/css`
     *
     * @param string $file
     * @param array $dependencies
     * @param string|null $handle
     * @param string|null $version
     */
    protected function enqueueStylesheet(string $file, array $dependencies = [], ?string $handle = null, ?string $version = null)
    {
        $this->wpEnqueue($file, $dependencies, $handle, $version);
    }

    /**
     * Enqueue Javascript Files From `assets/js`
     *
     * @param string $file
     * @param array $dependencies
     * @param string|null $handle
     * @param string|null $version
     */
    protected function enqueueScript(string $file, array $dependencies = [], ?string $handle = null, ?string $version = null)
    {
        $this->wpEnqueue($file, $dependencies, $handle, $version, 'js');
    }

    /**
     * Enqueue CSS-Stylesheet or Javascript Files From `assets/js|css`
     *
     * @param string $file
     * @param array $dependencies
     * @param string|null $handle
     * @param string|null $version
     * @param string $type
     */
    protected function wpEnqueue(string $file, array $dependencies = [], ?string $handle = null, ?string $version = null, string $type = 'css')
    {
        $file = '/'.$type.'/'.$file;
        if (!$version) {
            $version = $this->getAssetVersion($file);
        }
        $handle = !$handle ? static::getThemeSlug().'-'.substr(basename($file), 0, -(strlen($type) + 1)) : $handle;
        if ($type == 'css') {
            wp_enqueue_style($handle, static::getThemeUrl('/assets'.$file), $dependencies, $version);
            return;
        }
        wp_enqueue_script($handle, static::getThemeUrl('/assets'.$file), $dependencies, $version);
    }

    /**
     * Get Version From Mix Manifest File
     *
     * @param $file
     * @return string
     */
    protected function getAssetVersion($file): string
    {
        $manifest = static::getManifest();
        if (!empty($manifest[$file])) {
            $parts = explode('?id=', $manifest[$file]);
            if (!empty($parts[1])) {
                return $parts[1];
            }
        }

        return static::getThemeVersion();
    }

    public static function getThemeVersion(): string
    {
        if (empty(static::$themeVersion)) {
            static::$themeVersion = wp_get_theme()->get('Version');
        }

        return static::$themeVersion;
    }

    public static function getThemeSlug(): string
    {
        if (empty(static::$themeSlug)) {
            if (!empty(static::getConfig('slug'))) {
                static::$themeSlug = static::getConfig('slug');
            }

            static::$themeSlug = basename(dirname(__DIR__));
        }

        return static::$themeSlug;
    }

    public static function getManifest(): array
    {
        if (empty(static::$manifest)) {
            static::$manifest = json_decode(file_get_contents(static::getThemePath('assets/mix-manifest.json')), true);
        }

        return static::$manifest;
    }

    public static function getThemePath(string $file = ''): string
    {
        if (empty(static::$themePath)) {
            static::$themePath = dirname(__DIR__);
        }

        $file = trim($file, '/\\');

        $append = !$file ? '' : '/'.$file;

        return static::$themePath.$append;
    }

    public static function getAutoloadedPath(string $file = ''): string
    {
        if (empty(static::$autoloadedPath)) {
            static::$autoloadedPath = __DIR__;
        }

        $file = trim($file, '/\\');

        $append = !$file ? '' : '/'.$file;

        return static::$autoloadedPath.$append;
    }

    public static function getThemeUrl(string $file = ''): string
    {
        if (empty(static::$themeUrl)) {
            static::$themeUrl = get_stylesheet_directory_uri();
        }

        $file = trim($file, '/\\');

        $append = !$file ? '' : '/'.$file;

        return static::$themeUrl.$append;
    }

    public static function getNamespace(): string
    {
        return __NAMESPACE__;
    }
}
