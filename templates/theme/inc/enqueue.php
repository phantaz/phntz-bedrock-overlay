<?php
/**
 * Frontend assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', function () {
    $base = PHNTZ_THEME_URL . '/assets';
    $dir  = PHNTZ_THEME_PATH . '/assets';

    foreach ( [ 'phntz-main' => '/css/main.css' ] as $handle => $relative_path ) {
        if ( is_readable( $dir . $relative_path ) ) {
            $version = WP_DEBUG ? (string) filemtime( $dir . $relative_path ) : PHNTZ_THEME_VERSION;
            wp_enqueue_style( $handle, $base . $relative_path, [], $version );
        }
    }

    foreach ( [ 'phntz-main' => '/js/main.js' ] as $handle => $relative_path ) {
        if ( is_readable( $dir . $relative_path ) ) {
            $version = WP_DEBUG ? (string) filemtime( $dir . $relative_path ) : PHNTZ_THEME_VERSION;
            wp_enqueue_script( $handle, $base . $relative_path, [], $version, true );
            wp_script_add_data( $handle, 'type', 'module' );
        }
    }
}, 20 );
