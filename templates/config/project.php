<?php

use Roots\WPConfig\Config;

use function Env\env;

Config::define('WP_MEMORY_LIMIT', env('WP_MEMORY_LIMIT') ?: '256M');
Config::define('WP_MAX_MEMORY_LIMIT', env('WP_MAX_MEMORY_LIMIT') ?: '512M');

foreach ([
    'ACF_PRO_LICENSE',
    'BRICKS_LICENSE_KEY',
    'PERFMATTERS_LICENSE_KEY',
    'SEOPRESS_LICENSE_KEY',
] as $licenseConstant) {
    $licenseKey = env($licenseConstant);

    if (is_string($licenseKey) && $licenseKey !== '') {
        Config::define($licenseConstant, $licenseKey);
    }
}
