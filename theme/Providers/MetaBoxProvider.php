<?php

namespace NormanHuth\WpChild\Providers;

use NormanHuth\WpChild\Kernel;
use NormanHuth\WpChild\MetaBox;

class MetaBoxProvider extends Kernel
{
    protected static ?MetaBox $instance = null;

    /**
     * @return MetaBox|null
     */
    public static function instance(): ?MetaBox
    {
        if (self::$instance === null) {
            self::$instance = new MetaBox;
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
