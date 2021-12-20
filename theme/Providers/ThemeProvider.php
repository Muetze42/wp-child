<?php

namespace NormanHuth\WpChild\Providers;

use NormanHuth\WpChild\Kernel;

class ThemeProvider extends Kernel
{
    protected static ?ThemeProvider $instance = null;

    /**
     * Enqueue Theme Assets
     */
    public function enqueueAssets()
    {
        $this->enqueueStylesheet('theme.css');
        if ($this->isPluginActive('woocommerce')) {
            $this->enqueueScript('theme.js');
        }
    }

    /**
     * @return ThemeProvider|null
     */
    public static function instance(): ?ThemeProvider
    {
        if (self::$instance === null) {
            self::$instance = new ThemeProvider;
        }

        return self::$instance;
    }

    /**
     * ThemeProvider Constructor
     */
    protected function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }
}