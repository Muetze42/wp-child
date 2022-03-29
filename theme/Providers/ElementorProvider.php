<?php

namespace NormanHuth\WpChild\Providers;

use NormanHuth\WpChild\Kernel;

class ElementorProvider extends Kernel
{
    protected static ?ElementorProvider $instance = null;

    /**
     * @return ElementorProvider|null
     */
    static public function instance(): ?ElementorProvider
    {
        if (self::$instance === null) {
            self::$instance = new ElementorProvider;
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $this->addActions();
    }

    protected function addActions()
    {
        add_action('init', [$this, 'init']);
        add_action('plugins_loaded', [$this, 'pluginsLoaded']);
        add_action('elementor/elements/categories_registered', [$this, 'addElementorWidgetCategories']);
        add_action('elementor/widgets/widgets_registered', [$this, 'initWidgets'], 20);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'editorStyles']);
    }

    public function addElementorWidgetCategories($elementsManager)
    {
        $elementsManager->add_category(
            'norman-huth',
            [
                'title' => 'Norman Huth',
                'icon'  => 'fas fa-code',
            ]
        );
    }

    public function editorStyles()
    {
        $this->enqueueStylesheet('elementor-editor.css');
    }

    public function init()
    {
        load_plugin_textdomain('norman-huth');
    }

    public function initWidgets()
    {
        $folder = static::getAutoloadedPath('Elementor/Widgets/*');
        $namespace = static::getNamespace().'\\Elementor\\Widgets\\';
        $items = glob($folder, GLOB_ONLYDIR);
        foreach ($items as $item) {
            $class = basename($item);
            $class = $namespace.$class.'\\'.$class;
            if (class_exists($class)) {
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class);
            }
        }
    }
}
