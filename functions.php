<?php

use NormanHuth\WpChild\Providers\ThemeProvider;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__.'/vendor/autoload.php';

ThemeProvider::instance();