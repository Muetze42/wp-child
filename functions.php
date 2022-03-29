<?php

use NormanHuth\WpChild\Providers\ThemeProvider;
use NormanHuth\WpChild\WordPress;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__.'/vendor/autoload.php';

ThemeProvider::instance();

if (WordPress::isPluginActive('elementor')) {
    \NormanHuth\WpChild\Providers\ElementorProvider::instance();
}
if (WordPress::isPluginActive('meta-box-aio')) {
    \NormanHuth\WpChild\Providers\MetaBoxProvider::instance();
}
if (WordPress::isPluginActive('woocommerce')) {
    require_once ThemeProvider::getThemePath('functions/woocommerce.php');
    \NormanHuth\WpChild\Providers\WooCommerceProvider::instance();
}
