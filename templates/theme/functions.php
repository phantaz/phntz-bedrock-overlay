<?php
/**
 * {{THEME_NAME}} child theme.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PHNTZ_THEME_PATH', get_stylesheet_directory() );
define( 'PHNTZ_THEME_URL', get_stylesheet_directory_uri() );
define( 'PHNTZ_THEME_VERSION', wp_get_theme()->get( 'Version' ) ?: '1.0.0' );

foreach ( [ 'enqueue.php', 'elements.php', 'tweaks.php' ] as $phntz_module ) {
    require_once PHNTZ_THEME_PATH . '/inc/' . $phntz_module;
}
