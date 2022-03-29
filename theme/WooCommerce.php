<?php

namespace NormanHuth\WpChild;

use WC_Product;
use WC_Tax;

class WooCommerce extends Kernel
{
    protected static array $apiRoutes = [
        'wp-json',
        'wc-api',
    ];

    public static function registerErrorFilter()
    {
        add_filter('wp_php_error_message', function ($message, $error) {
            error_log(print_r($error).': '.print_r($message));
        });
    }

    public static function isApiRequest(): bool
    {
        $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        return WC()->is_rest_api_request() || in_array($uri[0], static::$apiRoutes);
    }

    public static function addFilter($hook_name, $callback, $priority = 10, $acceptedArgs = 1, $allowOnApi = false)
    {
        if ($allowOnApi || !static::isApiRequest()) {
            add_filter($hook_name, $callback, $priority, $acceptedArgs);
        }
    }

    public static function addAction($hook_name, $callback, $priority = 10, $acceptedArgs = 1, $allowOnApi = false)
    {
        if ($allowOnApi || !static::isApiRequest()) {
            add_action($hook_name, $callback, $priority, $acceptedArgs);
        }
    }

    // Todo: Testing with ´WC_Product´
    public static function getProductTaxInPercent(WC_Product $product)
    {
        $taxClasses = WC_Tax::get_rates($product->get_tax_class());
        if (!empty($taxClasses)) {
            $taxRate = reset($taxClasses);
            if (!empty($taxRate['rate'])) {
                return $taxRate['rate'];
            }
        }
        return 0;
    }
}
