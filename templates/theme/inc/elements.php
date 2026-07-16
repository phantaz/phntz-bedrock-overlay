<?php
/**
 * Bricks custom element registry.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', function () {
    if ( ! class_exists( '\Bricks\Elements' ) || ! class_exists( '\Bricks\Element' ) ) {
        return;
    }

    $elements = apply_filters( 'phntz/bricks/elements', [
        // 'custom-hero' => 'Phntz\\Bricks\\Element_Custom_Hero',
    ] );

    if ( ! is_array( $elements ) ) {
        return;
    }

    foreach ( $elements as $slug => $class_name ) {
        if ( ! is_string( $slug ) || ! is_string( $class_name ) ) {
            continue;
        }

        $file = PHNTZ_THEME_PATH . "/elements/class-{$slug}.php";

        if ( is_readable( $file ) ) {
            \Bricks\Elements::register_element( $file, $slug, $class_name );
        }
    }
}, 11 );

add_filter( 'bricks/builder/i18n', function ( $i18n ) {
    if ( is_array( $i18n ) ) {
        $i18n['phntz_category'] = esc_html__( 'Phantaz Elements', '{{THEME_SLUG}}' );
    }

    return $i18n;
} );
