<?php

namespace NormanHuth\WpChild\Providers;

use NormanHuth\WpChild\Kernel;

class WooCommerceProvider extends Kernel
{
    protected static ?WooCommerceProvider $instance = null;

    /**
     * @return WooCommerceProvider|null
     */
    public static function instance(): ?WooCommerceProvider
    {
        if (self::$instance === null) {
            self::$instance = new WooCommerceProvider;
        }

        return self::$instance;
    }
}
