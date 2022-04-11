<?php

namespace NormanHuth\WpChild\Providers;

use NormanHuth\WpChild\Kernel;
use NormanHuth\WpChild\MetaBox;

class MetaBoxProvider extends Kernel
{
    protected static ?MetaBoxProvider $instance = null;

    /**
     * @return MetaBoxProvider|null
     */
    public static function instance(): ?MetaBoxProvider
    {
        if (self::$instance === null) {
            self::$instance = new MetaBoxProvider;
        }

        return self::$instance;
    }

    /**
     * WordPress Constructor
     */
    protected function __construct()
    {
        $this->registerMetaBoxes();
    }

    protected function registerMetaBoxes()
    {
        add_filter('rwmb_meta_boxes', function ($metaBoxes) {
            return array_merge(MetaBox::getConfig('metaboxes'), array($metaBoxes));
        });
    }
}
