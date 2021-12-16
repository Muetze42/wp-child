<?php

namespace NormanHuth\WpChild\Providers;

class ThemeProvider
{
    /**
     * Optional: Custom Theme Slug
     */
    protected string $themeSlug = '';

    protected static ?ThemeProvider $instance = NULL;
    protected array $manifest;
    protected string $themePath;
    protected string $themeUrl;
    protected string $themeVersion;

    /**
     * Enqueue Theme Assets
     */
    public function enqueueAssets()
    {
        $this->enqueueStylesheet('theme.css');
        $this->enqueueScript('theme.js');
    }

    /**
     * @return ThemeProvider|null
     */
    static public function instance(): ?ThemeProvider
    {
        if (self::$instance === NULL) {
            self::$instance = new ThemeProvider;
        }

        return self::$instance;
    }

    /**
     * ThemeProvider Constructor
     */
    protected function __construct()
    {
        $this->themePath = dirname(__DIR__, 2);
        if (!$this->themeSlug) {
            $this->themeSlug = basename($this->themePath);
        }
        $this->themeUrl = get_stylesheet_directory_uri();
        $this->manifest = json_decode(file_get_contents($this->themePath.'/assets/mix-manifest.json'), true);

        add_action('init', [$this, 'hookInit']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    /**
     * `init` Hooks
     */
    public function hookInit()
    {
        $this->themeVersion = $this->getThemeVersion();
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
        $this->enqueueAsset($file, $dependencies, $handle, $version);
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
        $this->enqueueAsset($file, $dependencies, $handle, $version, 'js');
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
    protected function enqueueAsset(string $file, array $dependencies = [], ?string $handle = null, ?string $version = null, string $type = 'css')
    {
        $file = '/'.$type.'/'.$file;
        if (!$version) {
            $version = $this->getAssetVersion($file);
        }
        $handle = !$handle ? $this->themeSlug.'-'.substr(basename($file), 0, -(strlen($type)+1)) : $handle;
        if ($type == 'css') {
            wp_enqueue_style($handle, $this->themeUrl.'/assets'.$file, $dependencies, $version);
            return;
        }
        wp_enqueue_script($handle, $this->themeUrl.'/assets'.$file, $dependencies, $version);
    }

    /**
     * Get Version From Mix Manifest File
     *
     * @param $file
     * @return string
     */
    protected function getAssetVersion($file): string
    {
        if (!empty($this->manifest[$file])) {
            $parts = explode('?id=', $this->manifest[$file]);
            if (!empty($parts[1])) {
                return $parts[1];
            }
        }

        return $this->themeVersion;
    }

    /**
     * Get Theme Version From The Base `style.css`
     *
     * @return array|false|string
     */
    protected function getThemeVersion()
    {
        return wp_get_theme()->get('Version');
    }
}